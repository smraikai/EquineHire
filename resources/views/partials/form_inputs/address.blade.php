<div class="relative mb-10">
    <label for="address" class="block mb-2 font-medium text-gray-500 text-md">Address</label>
    <div class="relative">
        <input type="text" name="address" id="address" placeholder="Enter an address" required class="input"
            value="{{ old('address', $business->address ?? '') }}">
        <input type="hidden" name="is_valid_address" id="is_valid_address"
            value="{{ $business->address ? 'true' : 'false' }}">
        <div id="address-icon-container" class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
            <x-coolicon-circle-check class="{{ $business->address ? '' : 'hidden' }} w-5 h-5 text-emerald-500"
                id="address-icon-valid" />
            <x-coolicon-close-circle class="hidden w-5 h-5 text-red-500"
                id="address-icon-invalid" />
        </div>
    </div>
    <div id="addressError" class="mt-1 text-sm text-red-500"></div>
    <input type="hidden" name="city" id="city" value="{{ old('city', $business->city ?? '') }}">
    <input type="hidden" name="state" id="state" value="{{ old('state', $business->state ?? '') }}">
    <input type="hidden" name="zip_code" id="zip_code" value="{{ old('zip_code', $business->zip_code ?? '') }}">
    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $business->latitude ?? '') }}">
    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $business->longitude ?? '') }}">
</div>
