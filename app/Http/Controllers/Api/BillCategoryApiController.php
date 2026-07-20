<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BillCategoryResource;
use App\Models\BillCategory;
use Illuminate\Http\Request;

class BillCategoryApiController extends Controller
{
    /**
     * GET /api/bill-categories
     * List semua kategori tagihan. Support ?search= dan pagination.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $categories = BillCategory::query()
            ->when($search, fn ($q) => $q->where('category_name', 'like', "%{$search}%"))
            ->orderBy('category_name')
            ->paginate(10);

        return BillCategoryResource::collection($categories);
    }

    /**
     * GET /api/bill-categories/{id}
     * Detail satu kategori tagihan.
     */
    public function show(BillCategory $billCategory)
    {
        return new BillCategoryResource($billCategory);
    }
}
