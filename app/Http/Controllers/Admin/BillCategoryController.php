<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillCategory;
use App\Models\BillCategoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillCategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Fitur Search memfilter kategori berdasarkan nama
        $categories = BillCategory::when($search, function($query, $search) {
            return $query->where('category_name', 'like', "%{$search}%");
        })->get();

        // Menggunakan paginate(10) untuk membatasi maksimal 10 baris per halaman
        $logs = BillCategoryLog::orderBy('created_at', 'desc')->paginate(10);

        $searchPlaceholder = "Cari kategori...";

        return view('bill-categories.index', compact('categories', 'logs', 'searchPlaceholder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
        ]);

        $category = BillCategory::create([
            'category_name'  => $request->category_name,
            'price'          => $request->price,
            'default_active' => $request->default_active ?? 0,
        ]);

        BillCategoryLog::create([
            'category_name' => $category->category_name,
            'old_price'     => 0,
            'new_price'     => $request->price,
            'admin_name'    => Auth::user()->name ?? 'Admin',
            'action'        => 'TAMBAH KATEGORI'
        ]);

        return redirect()->back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    // MEMPERBAIKI BUG UPDATE: Menggunakan save() manual agar bypass proteksi fillable database
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name'  => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'default_active' => 'required|in:0,1',
        ]);

        $category = BillCategory::findOrFail($id);

        $oldPrice = $category->price;

        // Mengubah data secara eksplisit agar pasti berubah
        $category->category_name = $request->category_name;
        $category->price = $request->price;
        $category->default_active = $request->default_active;
        $category->save();

        $actionMsg = 'EDIT KATEGORI';
        if ($oldPrice != $request->price) {
            $actionMsg = 'UBAH HARGA: Rp ' . number_format($oldPrice, 0, ',', '.') . ' → Rp ' . number_format($request->price, 0, ',', '.');
        }

        BillCategoryLog::create([
            'category_name' => $category->category_name,
            'old_price'     => $oldPrice,
            'new_price'     => $request->price,
            'admin_name'    => Auth::user()->name ?? 'Admin',
            'action'        => $actionMsg,
        ]);

        return redirect()->back()->with('success', 'Kategori tagihan berhasil diperbarui!');
    }

    // FITUR BARU: Menghapus Kategori Tagihan (Remove Card)
    public function destroy($id)
    {
        $category = BillCategory::findOrFail($id);
        $categoryName = $category->category_name;

        $category->delete();

        BillCategoryLog::create([
            'category_name' => $categoryName,
            'old_price'     => $category->price,
            'new_price'     => 0,
            'admin_name'    => Auth::user()->name ?? 'Admin',
            'action'        => 'HAPUS KATEGORI'
        ]);

        return redirect()->back()->with('success', 'Kategori tagihan berhasil dihapus!');
    }

    public function toggleActive($id)
    {
        $category = BillCategory::findOrFail($id);

        $category->default_active = $category->default_active == 1 ? 0 : 1;
        $category->save();

        BillCategoryLog::create([
            'category_name' => $category->category_name,
            'old_price'     => $category->price,
            'new_price'     => $category->price,
            'admin_name'    => Auth::user()->name ?? 'Admin',
            'action'        => $category->default_active ? 'AKTIFKAN KATEGORI' : 'NONAKTIFKAN KATEGORI',
        ]);

        return redirect()->back()->with('success', 'Status default aktif berhasil diperbarui!');
    }
}
