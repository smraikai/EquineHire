<div id="boostJobModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50" aria-hidden="true"></div>

    <div class="flex items-end justify-center min-h-screen p-4 text-center sm:items-center sm:p-0">
        <div
            class="relative w-full px-4 pt-5 pb-4 overflow-hidden text-left transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:max-w-lg sm:w-full sm:p-6">
            <div>
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-blue-100 rounded-full">
                    <x-heroicon-o-rocket-launch class="w-6 h-6 text-blue-600" />
                </div>
                <div class="mt-3 text-center">
                    <h3 class="text-xl font-semibold leading-6 text-gray-900 sm:text-xl" id="modal-title">
                        Boost Your Job Post: 30 Days for Just ${{ number_format(config('job_boost.price') / 100, 0) }}

                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Increase your job listings visibility and attract talent faster.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <ul role="list" class="mt-4 space-y-3">
                    <li class="flex items-start">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-check-circle class="w-5 h-5 text-blue-500" />
                        </div>
                        <p class="ml-3 text-sm leading-5 text-gray-600">Premium placement above non-boosted listings</p>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-check-circle class="w-5 h-5 text-blue-500" />
                        </div>
                        <p class="ml-3 text-sm leading-5 text-gray-600">Eye-catching design to stand out</p>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-check-circle class="w-5 h-5 text-blue-500" />
                        </div>
                        <p class="ml-3 text-sm leading-5 text-gray-600">Significantly increased visibility and
                            engagement</p>
                    </li>
                </ul>

                @include('partials.dashboard._boost-comparison')

                <div class="mt-6 rounded-md">
                    <div class="flex">
                        <div class="flex-1 text-center">
                            <p class="font-extrabold text-blue-700 text-md"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 space-y-2 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3 sm:space-y-0">
                <button type="button" id="confirmBoostButton"
                    class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 sm:col-start-2">
                    <span>Boost Now</span>
                    <x-heroicon-m-chevron-right class="w-4 h-4 ml-2" />
                </button>
                <button type="button" onclick="closeBoostModal()"
                    class="inline-flex justify-center w-full px-3 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:col-start-1">
                    Maybe Later
                </button>
            </div>
        </div>
    </div>
</div>
