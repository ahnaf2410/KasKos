<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\BillCategory;
use Illuminate\Http\Request;

class BillCategoryController extends Controller
{
    /**
     * Daftar kategori tagihan (read-only untuk penghuni).
     * Detail kategori ditampilkan lewat modal di halaman yang sama (tidak pindah halaman).
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $categories = BillCategory::query()
            ->when($search, function ($query) use ($search) {
                $query->where('category_name', 'like', "%{$search}%");
            })
            ->orderBy('category_name')
            ->paginate(10)
            ->withQueryString();

        return view('tenant.bill-categories.index', compact('categories', 'search'));
    }
}
