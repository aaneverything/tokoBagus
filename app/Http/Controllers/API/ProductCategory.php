<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_Category;
use Illuminate\Http\Request;

class ProductCategory extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $name = $request->input('name');
        $show_product = $request->input('show_product');

        if ($id) {
            $category = Product_Category::with(['products'])->find($id);
            if ($category) {
                return ResponseFormatter::success(
                    $category,
                    'Data kategori berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data kategori tidak ditemukan',
                    404
                );
            };
        }

        $category = Product_Category::query();

        if ($name) {
            $category->where('name', 'like', "%{$name}%");
        }

        if ($show_product) {
            $category->with('products');
        }

        return ResponseFormatter::success(
            $category->paginate($limit),
            'Data kategori berhasil diambil'
        );
    }
}
