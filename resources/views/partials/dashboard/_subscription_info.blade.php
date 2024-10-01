@if (auth()->user()->subscription('default'))
    <div class="mb-6 overflow-hidden bg-white border sm:rounded-lg">
        <div class="px-4 sm:px-6 sm:py-2">
            <dl class="divide-y divide-gray-200">
                @if (auth()->user()->subscription('default'))
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-1 md:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if (auth()->user()->subscription('default')->active())
                                <span
                                    class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                    Active
                                </span>
                            @elseif(auth()->user()->subscription('default')->onGracePeriod())
                                <span
                                    class="inline-flex px-2 text-xs font-semibold leading-5 text-yellow-800 bg-yellow-100 rounded-full">
                                    Grace Period
                                </span>
                            @else
                                <span
                                    class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                    Inactive
                                </span>
                            @endif
                        </dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-1 md:grid-cols-3 sm:gap-4">
                        <dt class="text-sm font-medium text-gray-500">Next Billing Date</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ \Carbon\Carbon::createFromTimestamp(auth()->user()->subscription('default')->asStripeSubscription()->current_period_end)->format('F j, Y') }}
                        </dd>
                    </div>
                @else
                    <div class="py-4 sm:py-5 sm:px-6">
                        <p class="text-sm text-gray-500">You don't have an active subscription.</p>
                    </div>
                @endif
            </dl>
        </div>
    </div>
@endif

@php
    $user = auth()->user();
    $activeSubscription = $user->subscriptions()->where('stripe_status', 'active')->first();
    $hasActiveSubscription = $activeSubscription !== null;

    ////////////////////////////////////////////
    // Debug for Subscription Info
    ////////////////////////////////////////////
    // $debug = [
    //     'user_id' => $user->id,
    //     'subscription_count' => $user->subscriptions()->count(),
    //     'all_subscriptions' => $user
    //         ->subscriptions()
    //         ->get()
    //         ->map(function ($sub) {
    //             return [
    //                 'name' => $sub->name,
    //                 'type' => $sub->type,
    //                 'stripe_status' => $sub->stripe_status,
    //                 'stripe_id' => $sub->stripe_id,
    //             ];
    //         }),
    //     'active_subscription' => $activeSubscription
    //         ? [
    //             'name' => $activeSubscription->name,
    //             'type' => $activeSubscription->type,
    //             'stripe_status' => $activeSubscription->stripe_status,
    //             'stripe_id' => $activeSubscription->stripe_id,
    //         ]
    //         : 'No active subscription',
    //     'has_active_subscription' => $hasActiveSubscription,
    // ];
    //
    //           <!-- Debug information (remove in production) -->
    //           <div class="py-4 sm:py-5">
    //              <pre>{{ json_encode($debug, JSON_PRETTY_PRINT) }}</pre>
    //           </div>
    //

@endphp



@if ($hasActiveSubscription)
    <div class="mb-6 overflow-hidden bg-white border sm:rounded-lg">
        <div class="px-4 sm:px-6 sm:py-2">
            <dl class="divide-y divide-gray-200">
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-1 md:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <span
                            class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                            Active
                        </span>
                    </dd>
                </div>
                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-1 md:grid-cols-3 sm:gap-4">
                    <dt class="text-sm font-medium text-gray-500">Next Billing Date</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        @if ($activeSubscription && $activeSubscription->asStripeSubscription())
                            {{ \Carbon\Carbon::createFromTimestamp($activeSubscription->asStripeSubscription()->current_period_end)->format('F j, Y') }}
                        @else
                            N/A
                        @endif
                    </dd>
                </div>


            </dl>
        </div>
    </div>
@else
    <div class="p-4 mb-4 text-yellow-700 bg-yellow-100 border-l-4 border-yellow-500" role="alert">
        <p class="font-bold">No Active Subscription</p>
        <p>Subscribe now to list or edit your business listing.</p>
        <a href="{{ route('subscription.plans') }}"
            class="inline-block px-4 py-2 mt-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-600">
            Choose a Plan
        </a>
    </div>
@endif
