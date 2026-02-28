<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 10);
        $name = $request->input('name');
        $description = $request->input('description');
        $tags = $request->input('tags');
        $categories = $request->input('categories');
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to');


        if ($id) {
            $product = Product::with(['category', 'galleries'])->find($id);
            if ($product) {
                return ResponseFormatter::success(
                    $product,
                    'Data produk berhasil diambil'
                );
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data produk tidak ditemukan',
                    404
                );
            };
        }

        $query = Product::with(['category', 'galleries']);

        if ($name) {
            $query->where('name', 'like', "%{$name}%");
        }

        if ($description) {
            $query->where('description', 'like', "%{$description}%");
        }

        if ($tags) {
            $query->where('tags', 'like', "%{$tags}%");
        }

        if ($price_from) {
            $query->where('price', '>=', $price_from);
        }

        if ($price_to) {
            $query->where('price', '<=', $price_to);
        }

        if ($categories) {
            $query->where('categories_id', $categories);
        }
        return ResponseFormatter::success(
            $query->paginate($limit),
            'Data produk berhasil diambil'
        );
    }
}
