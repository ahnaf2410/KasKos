@extends('layouts.app', ['activePage' => 'rooms'])

@section('content')


    <div class="max-w-3xl mx-auto py-8">

        <div class="bg-white rounded-lg shadow p-6">

            <h2 class="text-2xl font-bold mb-6">
                Edit Room
            </h2>

            <form
                action="{{ route('admin.rooms.update',$room) }}"
                method="POST">

                @csrf
                @method('PUT')

                @include('admin.rooms._form')

                <select name="tenant_id">

<option value="">Kosong</option>

@foreach($tenants as $tenant)

<option
value="{{ $tenant->id }}"
{{ $room->tenant_id == $tenant->id ? 'selected' : '' }}>

{{ $tenant->name }}

</option>

@endforeach

</select>

                <div class="mt-6 flex gap-3">

                    <button
                        class="bg-green-600 text-white px-5 py-2 rounded-lg">
                        Update
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

@endsection