<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $categories = Category::all();
            return $this->apiSuccess($categories, 200, 'Success');
        } catch (\Throwable $th) {
            return $this->apiError('Error', 500, $th);
        }
    }

    public function orderByAmountProduct()
    {
        try {
            $categories = Category::withCount('product')->orderBy('product_count', 'desc')->get();
            return $this->apiSuccess($categories, 200, 'Success');
        } catch (\Throwable $th) {
            return $this->apiError('Error', 500, $th);
        }
    }
}
