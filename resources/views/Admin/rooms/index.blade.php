<x-app-layout>

<div class="max-w-7xl mx-auto py-8">

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-5">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between mb-5">

        <form>

            <input
                type="text"
                name="search"
                placeholder="Search room..."
                value="{{ request('search') }}"
                class="rounded-lg border-gray-300">

        </form>

        <a
            href="{{ route('admin.rooms.create') }}"
            class="bg-blue-600 text-white px-5 py-2 rounded-lg">

            + Add Room

        </a>

    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-3">Room</th>

                    <th>Floor</th>

                    <th>Rental Price</th>

                    <th>Status</th>

                    <th width="170">Action</th>

                </tr>

            </thead>

            <tbody>

            @forelse($rooms as $room)

                <tr class="border-t">

                    <td class="p-3">
                        {{ $room->room_number }}
                    </td>

                    <td>
                        {{ $room->floor }}
                    </td>

                    <td>
                        Rp {{ number_format($room->rental_price,0,',','.') }}
                    </td>

                    <td>

                        @if($room->status=='vacant')

                            <span class="text-green-600">
                                Vacant
                            </span>

                        @else

                            <span class="text-red-600">
                                Occupied
                            </span>

                        @endif

                    </td>

                    <td>

                        <div class="flex gap-2">

                            <a
                                href="{{ route('admin.rooms.edit',$room) }}"
                                class="bg-yellow-500 text-white px-3 py-1 rounded">

                                Edit

                            </a>

                            <form
                                action="{{ route('admin.rooms.destroy',$room) }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Delete this room?')"
                                    class="bg-red-600 text-white px-3 py-1 rounded">

                                    Delete

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="text-center p-5">

                        No data found.

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-5">

        {{ $rooms->links() }}

    </div>

</div>

</x-app-layout>