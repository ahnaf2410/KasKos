<x-app-layout>

    <div class="max-w-3xl mx-auto py-8">

        <div class="bg-white rounded-lg shadow p-6">

            <h2 class="text-2xl font-bold mb-6">
                Add Room
            </h2>

            <form action="{{ route('admin.rooms.store') }}" method="POST">

                @csrf

                @include('admin.rooms._form')

                <div class="mt-6 flex gap-3">

                    <button
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg">
                        Save
                    </button>

                    <a
                        href="{{ route('admin.rooms.index') }}"
                        class="bg-gray-300 px-5 py-2 rounded-lg">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>