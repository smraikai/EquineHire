<div x-data="{
    name: '{{ old('name', $business->name ?? '') }}',
    nameError: '',
    validateName() {
        if (this.name.trim() === '') {
            this.nameError = 'Name is required.';
        } else {
            const pattern = /^[A-Za-z\s]{3,}$/; // Regex allowing only letters and spaces, with a minimum length of 3 characters
            this.nameError = this.name.match(pattern) ? '' : 'Name must only contain letters and spaces and be at least 3 characters long.';
        }
    }
}" class="mb-10">
    <label for="name" class="block mb-2 font-medium text-gray-500 text-md">Name</label>
    <div class="relative">
        <input type="text" name="name" id="name" placeholder="Enter business name" required class="input"
            x-model="name" @input="validateName()">
        <div x-show="!nameError && name.length > 0"
            class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <x-coolicon-circle-check class="w-5 h-5 text-blue-500" />
        </div>
    </div>
    <div id="nameError" class="mt-1 text-sm text-red-500" x-text="nameError"></div>
</div>
