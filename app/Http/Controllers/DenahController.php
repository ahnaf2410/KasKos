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
        $kamars = Room::orderBy('lantai')
            ->orderBy('nomor_kamar')
            ->get()
            ->groupBy('lantai');

        return view('denah.index', compact('kamars'));
    }
}
