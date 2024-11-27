                <div class="grid max-w-md grid-cols-1 gap-8 mx-auto mt-10 isolate lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    @foreach ($plans as $index => $plan)
                        <div
                            class="rounded-3xl shadow-md p-8 ring-1 {{ $index === 1 ? 'ring-blue-500 ring-2' : 'ring-gray-200' }} bg-white xl:p-10">
                            <div class="flex items-center justify-between gap-x-4">
                                <h3 id="{{ is_callable($plan['id']) ? $plan['id']() : $plan['id'] }}"
                                    class="text-lg font-semibold leading-8 text-gray-900">
                                    {{ $plan['name'] }}
                                </h3>
                                @if ($index === 1)
                                    <p
                                        class="rounded-full bg-blue-600 px-2.5 py-1 text-xs font-semibold leading-5 text-white">
                                        Most popular</p>
                                @endif
                            </div>
                            <p class="flex items-baseline mt-6 gap-x-1">
                                <span class="text-4xl font-bold tracking-tight text-gray-900">
                                    {{ app(App\Services\LocationService::class)->getCurrencySymbol() }}{{ $plan['prices'][app(App\Services\LocationService::class)->getCurrency()] }}
                                </span>
                                <span class="text-sm font-semibold leading-6 text-gray-600">
                                    /{{ $plan['interval'] }}
                                </span>
                            </p>
                            <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600">
                                @foreach ($plan['features'] as $feature)
                                    <li class="flex gap-x-3">
                                        <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20"
                                            fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                            <form action="{{ route('subscription.store-plan') }}" method="POST" class="mt-8">
                                @csrf
                                <input type="hidden"
                                    value="{{ is_callable($plan['id']) ? $plan['id']() : $plan['id'] }}" name="plan">
                                <input type="hidden" value="{{ $plan['name'] }}" name="planName">
                                <button type="submit"
                                    class="w-full px-3 py-2 text-sm font-semibold leading-6 text-center text-white bg-blue-600 rounded-md shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 hover:bg-blue-700 focus-visible:outline-blue-600">
                                    Choose Plan
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
