<div class="bg-white rounded-xl shadow-md p-6">

    <div class="flex justify-between items-center">

        <div>

            <h2 class="text-xl font-bold">
                Kamar {{ $room->room_number }}
            </h2>

            <p class="text-gray-500">
                Lantai {{ $room->floor }}
            </p>

        </div>

        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700">

            Kosong

        </span>

    </div>

    <div class="mt-4">

        <p class="text-2xl font-bold text-blue-600">

            Rp {{ number_format($room->rental_price) }}

        </p>

    </div>

    <div class="mt-6">

        <a href="{{ route('tenant.rooms.show',$room) }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg">

            Detail

        </a>

    </div>

</div>