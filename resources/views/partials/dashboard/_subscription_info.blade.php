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
                                    class="inline-flex px-2 text-xs font-semibold leading-5 text-emerald-800 bg-emerald-100 rounded-full">
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

@if (auth()->user()->subscription('default'))
    @if (auth()->user()->subscription('default')->onGracePeriod())
        <div class="p-4 mb-4 text-yellow-700 bg-yellow-100 border-l-4 border-yellow-500" role="alert">
            <p class="font-bold">Subscription Expiring Soon</p>
            <p>Your subscription will end on
                {{ auth()->user()->subscription('default')->ends_at->format('F j, Y') }}.
                Renew now to maintain your listing.</p>
            <a href="{{ route('subscription.plans') }}"
                class="inline-block px-4 py-2 mt-2 font-bold text-white bg-yellow-500 rounded hover:bg-yellow-600">
                Renew Subscription
            </a>
        </div>
    @elseif(!auth()->user()->subscription('default')->active())
        <div class="p-4 mb-4 text-red-700 bg-red-100 border-l-4 border-red-500" role="alert">
            <p class="font-bold">Subscription Expired</p>
            <p>Your subscription has expired. Renew now to reactivate your listing.</p>
            <a href="{{ route('subscription.plans') }}"
                class="inline-block px-4 py-2 mt-2 font-bold text-white bg-red-500 rounded hover:bg-red-600">
                Renew Subscription
            </a>
        </div>
    @endif
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