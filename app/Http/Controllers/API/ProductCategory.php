<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Product_Category;
use Illuminate\Http\Request;

class ProductCategory extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('name');
        $show_product = $request->input('show_product');


        if ($id) {
            $product = Product_Category::with(['category'])->find($id);
            if ($product) {
                return ResponseFormatter::success(
                    $product,
                    'data produk berhasil di jikuk'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'gaada njir error',
                    404
                );
            };
        }

        $category = Product_Category::query();

        if ($name) {
            $category->where('name', 'like', '%', $name, '%');
        }

        if ($show_product) {
            $category->with('product');
        }

        return ResponseFormatter::success(
            $category->paginate($limit),
            'data kategori berhasil di jikuk'
        );
    }
}
