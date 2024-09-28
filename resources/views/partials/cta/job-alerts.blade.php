<div class="relative py-16 bg-blue-50">
    <div class="relative z-10 px-6 mx-auto max-w-7xl lg:px-8">
        <div class="">
            <div class="grid grid-cols-1 gap-5 sm:gap-20 lg:grid-cols-2">
                <div class="flex flex-col justify-center">
                    <div class="space-y-4">
                        <h2 class="text-3xl tracking-tight text-gray-900 fancy-title sm:text-5xl">Get Job Notifications
                        </h2>
                        <x-divider class="" />
                        <p class="max-w-lg text-lg leading-8 text-gray-600">Discover new job openings in the equestrian
                            industry – sent straight to your inbox.</p>
                        <div class="pt-4 border-t border-blue-200">
                            <p class="text-sm text-gray-500">Be part of a growing community of equine professionals.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col justify-center">
                    <form id="emailOctopusForm" class="space-y-4">
                        @csrf
                        <div class="flex space-x-4">
                            <div class="flex-grow">
                                <label for="email-address" class="sr-only">Email address</label>
                                <input id="email-address" name="email" type="email" autocomplete="email" required
                                    class="w-full px-3.5 py-2 text-gray-900 bg-white border-0 rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6"
                                    placeholder="Enter your email">
                            </div>
                            <button type="submit" id="submitButton"
                                class="px-4 py-2 text-sm font-semibold text-white transition-colors duration-200 bg-blue-600 rounded-md shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                Subscribe
                            </button>
                        </div>
                    </form>
                    <div id="successMessage" class="hidden mt-4 text-green-600 animate-fade-in-up">
                        Thank you for subscribing! Be on the lookout for weekly updates!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('emailOctopusForm').addEventListener('submit', function(e) {
        e.preventDefault();

        var form = this;
        var email = document.getElementById('email-address').value;
        var button = document.getElementById('submitButton');
        var successMessage = document.getElementById('successMessage');

        button.innerHTML = 'Subscribing...';
        button.disabled = true;

        fetch('{{ route('subscribe') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({
                    email: email
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    successMessage.classList.remove('hidden');
                    form.reset();
                } else {
                    alert('Uh oh: ' + (data.error || 'Please try again.'));
                }
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            })
            .finally(() => {
                button.innerHTML = 'Subscribe';
                button.disabled = false;
            });
    });
</script>
