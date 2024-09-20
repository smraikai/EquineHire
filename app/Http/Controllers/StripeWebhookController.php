<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController;
use Stripe\Webhook;

class StripeWebhookController extends WebhookController
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook.secret');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            Log::error('Invalid webhook payload: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            Log::error('Invalid webhook signature: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $method = 'handle' . str_replace('.', '_', $event->type);

        if (method_exists($this, $method)) {
            $this->{$method}($event->data->object);
        } else {
            Log::info('Unhandled webhook event: ' . $event->type);
        }

        return response()->json(['status' => 'success']);
    }

    protected function handleCustomerSubscriptionCreated(array $payload)
    {
        Log::info('Handling customer.subscription.created event');

        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        Log::info('User: ' . ($user ? $user->id : 'not found'));

        if ($user) {
            $data = $payload['data']['object'];

            Log::info('Subscription data: ' . json_encode($data));

            $subscription = $user->subscriptions()->create([
                'name' => $data['items']['data'][0]['plan']['nickname'],
                'stripe_id' => $data['id'],
                'stripe_status' => $data['status'],
                'stripe_price' => $data['items']['data'][0]['price']['id'],
                'quantity' => $data['quantity'],
                'trial_ends_at' => $data['trial_end'] ? date('Y-m-d H:i:s', $data['trial_end']) : null,
                'ends_at' => null,
            ]);

            Log::info('Subscription created: ' . $subscription->id);
            Log::info('Subscription data: ' . json_encode($subscription));
        }
    }

    protected function handleCustomerSubscriptionUpdated(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if ($user) {
            $data = $payload['data']['object'];

            $user->subscriptions->filter(function ($subscription) use ($data) {
                return $subscription->stripe_id === $data['id'];
            })->each(function ($subscription) use ($data) {
                $subscription->update([
                    'name' => $data['items']['data'][0]['plan']['nickname'],
                    'stripe_status' => $data['status'],
                    'stripe_price' => $data['items']['data'][0]['price']['id'],
                    'quantity' => $data['quantity'],
                    'trial_ends_at' => $data['trial_end'] ? date('Y-m-d H:i:s', $data['trial_end']) : null,
                    'ends_at' => null,
                ]);

                Log::info('Subscription updated: ' . $subscription->id);
            });
        }
    }

    protected function handleCustomerSubscriptionDeleted(array $payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);

        if ($user) {
            $data = $payload['data']['object'];

            $user->subscriptions->filter(function ($subscription) use ($data) {
                return $subscription->stripe_id === $data['id'];
            })->each(function ($subscription) {
                $subscription->markAsCancelled();

                Log::info('Subscription deleted: ' . $subscription->id);
            });
        }
    }

    protected function getUserByStripeId($stripeId)
    {
        return User::where('stripe_id', $stripeId)->first();
    }
}