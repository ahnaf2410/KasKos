<?php

namespace App\Http\Controllers;

use App\Models\Room;

class DenahController extends Controller
{
    /**
     * Tampilkan denah kamar (visual only, belum interaktif).
     * Dikelompokkan per lantai, warna kartu mengikuti status kamar.
     */
    public function index()
    {
        // lantai diganti floor, nomor_kamar diganti room_number
        $kamars = Room::orderBy('floor')
            ->orderBy('room_number')
            ->get()
            ->groupBy('floor');

        return view('denah.index', compact('kamars'));
    }
}
