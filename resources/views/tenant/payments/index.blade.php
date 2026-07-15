@extends('layouts.app', ['activePage' => 'pembayaran'])

@section('content')
<div class="max-w-7xl mx-auto py-8">

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-8">

        <div>

            <h1 class="text-3xl font-bold">
                Pembayaran Patungan
            </h1>

            <p class="text-gray-500">
                Upload bukti pembayaran tagihan patungan.
            </p>

        </div>

    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden">

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="p-4 text-left">
                        Tagihan
                    </th>

                    <th>
                        Periode
                    </th>

                    <th>
                        Nominal
                    </th>

                    <th>
                        Status
                    </th>

                    <th>
                        Bukti
                    </th>

                    <th>
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

            @forelse($payments as $payment)

            <tr class="border-t">

                <td class="p-4">

                    {{ $payment->bill->title }}

                </td>

                <td>

                    {{ $payment->bill->period }}

                </td>

                <td>

                    Rp {{ number_format($payment->split_amount,0,',','.') }}

                </td>

                <td>

                    @if($payment->status=='paid')

                        <span class="text-green-600">
                            Lunas
                        </span>

                    @elseif($payment->status=='pending_verification')

                        <span class="text-yellow-600">
                            Menunggu Verifikasi
                        </span>

                    @else

                        <span class="text-red-600">
                            Belum Bayar
                        </span>

                    @endif

                </td>

                <td>

                    @if($payment->payment_slip)

                        ✅ Sudah Upload

                    @else

                        -

                    @endif

                </td>

                <td>

                    <div class="flex gap-2 justify-center">

                        @if(!$payment->payment_slip)

                            {{-- Belum ada bukti sama sekali --}}
                            <a
                                href="{{ route('tenant.payments.create', ['payment' => $payment->id]) }}"
                                class="bg-red-600 text-white px-3 py-2 rounded-lg text-sm">
                                Upload
                            </a>

                        @else

                            {{-- Sudah ada bukti: selalu bisa preview --}}
                            <a
                                href="{{ route('tenant.payments.show', $payment) }}"
                                class="bg-slate-600 text-white px-3 py-2 rounded-lg text-sm">
                                Preview
                            </a>

                            @if($payment->status !== 'paid')

                                {{-- Boleh diedit/dihapus selama belum diverifikasi admin --}}
                                <a
                                    href="{{ route('tenant.payments.edit', $payment) }}"
                                    class="bg-yellow-500 text-white px-3 py-2 rounded-lg text-sm">
                                    Edit
                                </a>

                                <form
                                    action="{{ route('tenant.payments.destroy', $payment) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        onclick="return confirm('Hapus bukti pembayaran ini?')"
                                        class="bg-gray-400 text-white px-3 py-2 rounded-lg text-sm">
                                        Hapus
                                    </button>
                                </form>

                            @endif

                        @endif

                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="6" class="text-center p-8">

                    Tidak ada pembayaran.

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="mt-6">

        {{ $payments->links() }}

    </div>

</div>

@endsection