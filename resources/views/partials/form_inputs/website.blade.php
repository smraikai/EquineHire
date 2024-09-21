<div x-data="{
    website: '{{ old('website', $business->website ?? '') }}',
    websiteError: '',
    validateWebsite() {
        if (this.website.length === 0) {
            this.websiteError = '';
            return;
        }
        const pattern = /^https:\/\/([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/;
        this.websiteError = this.website.match(pattern) ? '' : 'Enter a valid web address (https:// required)';
    }
}" class="relative mb-10">
    <label for="website" class="block mb-2 font-medium text-gray-500 text-md">Website or Social Link <span
            class="text-xs">(Optional)</span></label>
    <div class="relative">
        <input type="url" name="website" id="website" placeholder="https://yourwebsite.com" class="input"
            x-model="website" @input="validateWebsite()">
        <div x-show="!websiteError && website.length > 0"
            class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <x-coolicon-circle-check class="w-5 h-5 text-blue-500" />
        </div>
    </div>
    <div id="websiteError" class="mt-1 text-sm text-red-500" x-text="websiteError"></div>
</div>
