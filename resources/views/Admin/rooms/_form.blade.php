<div class="space-y-5">

    <div>
        <label class="block text-sm font-medium mb-1">
            Room Number
        </label>

        <input
            type="text"
            name="room_number"
            value="{{ old('room_number', $room->room_number ?? '') }}"
            class="w-full rounded-lg border-gray-300">

        @error('room_number')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">
            Floor
        </label>

        <input
            type="number"
            name="floor"
            value="{{ old('floor', $room->floor ?? '') }}"
            class="w-full rounded-lg border-gray-300">

        @error('floor')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">
            Rental Price
        </label>

        <input
            type="number"
            step="0.01"
            name="rental_price"
            value="{{ old('rental_price', $room->rental_price ?? '') }}"
            class="w-full rounded-lg border-gray-300">

        @error('rental_price')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    <div>
    <label class="block text-sm font-medium mb-1">
        Penghuni
    </label>

    <select
        name="tenant_id"
        class="w-full rounded-lg border-gray-300">

        <option value="">Kosong</option>

        @foreach($tenants as $tenant)

            <option
                value="{{ $tenant->id }}"
                @selected(old('tenant_id', $room->tenant_id ?? '') == $tenant->id)>

                {{ $tenant->name }}

            </option>

        @endforeach

    </select>

    @error('tenant_id')
        <small class="text-red-500">{{ $message }}</small>
    @enderror
</div>

    <!-- <div>
        <label class="block text-sm font-medium mb-1">
            Status
        </label>

        <select
            name="status"
            class="w-full rounded-lg border-gray-300">

            <option value="vacant"
                @selected(old('status', $room->status ?? '') == 'vacant')>
                Vacant
            </option>

            <option value="occupied"
                @selected(old('status', $room->status ?? '') == 'occupied')>
                Occupied
            </option>

        </select>

        @error('status')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div> -->

    <div>
        <label class="block text-sm font-medium mb-1">
            Description
        </label>

        <textarea
            name="description"
            rows="4"
            class="w-full rounded-lg border-gray-300">{{ old('description', $room->description ?? '') }}</textarea>
    </div>

</div>