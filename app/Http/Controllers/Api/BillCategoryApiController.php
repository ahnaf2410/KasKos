<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BillCategoryResource;
use App\Models\BillCategory;
use Illuminate\Http\Request;

class BillCategoryApiController extends Controller
{
    public function index()
    {
        return response()->json(BillCategory::all());
    }

    public function show($id)
    {
        $category = BillCategory::findOrFail($id);
        return response()->json($category);
    }
}

