    <div x-data="{
        email: '{{ old('email', $business->email ?? '') }}',
        emailError: '',
        phone: '{{ old('phone', $business->phone ?? '') }}',
        phoneError: '',
        validateEmail() {
            const pattern = /^[^@\s]+@[^@\s]+\.[^@\s]{2,}$/;
            this.emailError = this.email.match(pattern) ? '' : 'Please enter a valid email address with a valid domain extension.';
        },
        validatePhone() {
            const pattern = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
            if (this.phone.length > 14) {
                // If the phone number exceeds the formatting limits (shouldn't normally happen with input limits in place)
                this.phoneError = '';
            } else {
                this.phoneError = pattern.test(this.phone) ? '' : 'Please enter a valid phone number.';
            }
        }
    
    }" class="relative">
        <div class="grid gap-4 mb-10 md:grid-cols-2">
            <!-- Email input -->
            <div class="relative mb-10 md:mb-0">
                <label for="email" class="block mb-2 font-medium text-gray-500 text-md">Email</label>
                <div class="relative">
                    <input type="email" name="email" id="email" placeholder="email@website.com" required
                        class="input" x-model="email" @input="validateEmail()">
                    <div x-show="!emailError && email.length > 0"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <x-coolicon-circle-check class="w-5 h-5 text-blue-500" />
                    </div>
                </div>
                <div id="emailError" class="mt-1 text-sm text-red-500" x-text="emailError"></div>
            </div>
            <!-- Phone input -->
            <div class="relative mb-10 md:mb-0">
                <label for="phone" class="block mb-2 font-medium text-gray-500 text-md">Phone</label>
                <div class="relative">
                    <input type="tel" name="phone" id="phone" required placeholder="(xxx) xxx-xxxx"
                        class="input" x-model="phone" @input="validatePhone()">
                    <div x-show="!phoneError && phone.length > 0"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <x-coolicon-circle-check class="w-5 h-5 text-blue-500" />
                    </div>
                </div>
                <div id="phoneError" class="mt-1 text-sm text-red-500" x-text="phoneError"></div>
            </div>
        </div>
    </div>
