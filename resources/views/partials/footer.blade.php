<footer class="pt-20 pb-20 bg-gray-50">
    <div class="container px-4 mx-auto max-w-7xl">
        <div class="flex flex-wrap">
            <div class="w-full px-0 mb-8 lg:w-1/2 lg:mb-0">
                <div class="logo">
                    <a href="{{ route('home') }}" class="text-3xl">
                        EquineHire
                    </a>
                </div>
                <div class="mt-4">
                    <p class="max-w-sm text-sm text-gray-500">&copy; <?= date('Y') ?> EquineHire, a project of <a
                            href="https://equinehire.com" target="_blank">Equine
                            Hire, LLC.</a> Proudly built in Kentucky.</p>
                </div>
            </div>
            <div class="w-full px-0 mb-8 lg:w-1/4 lg:mb-0">
                <h5 class="mb-2 font-bold text-gray-900">Explore Jobs</h5>
                <ul class="space-y-3 list-none footer-links">
                    @foreach (\App\Models\JobListingCategory::all() as $category)
                        <li>
                            <a href="{{ route('jobs.index', ['categories[]' => $category->id]) }}"
                                class="text-gray-600 hover:text-gray-900">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="w-full px-0 lg:w-1/4">
                <h5 class="mb-2 font-bold text-gray-900">Employer</h5>
                <ul class="space-y-3 list-none footer-links">
                    <li>
                        <script language="JavaScript">
                            <!--
                            var name = "help";
                            var domain = "equinehire.com";
                            document.write('<a href=\"mailto:' + name + '@' + domain + '\" class="text-gray-600 hover:text-gray-900">');
                            document.write('Contact</a>');
                            // 
                            -->
                        </script>
                    </li>
                    <li><a href="/privacy-policy" class="text-gray-600 hover:text-gray-900">Privacy Policy</a></li>
                    <li><a href="/terms-of-service" class="text-gray-600 hover:text-gray-900">Terms of Service</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
