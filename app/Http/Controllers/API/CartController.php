<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Lihat semua item di cart user yang sedang login.
     */
    public function index()
    {
        try {
            $carts = Cart::with(['product.galleries', 'product.category'])
                ->where('users_id', Auth::id())
                ->get();

            return ResponseFormatter::success($carts, 'Data cart berhasil diambil');
        } catch (Exception $error) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan pada server', 500);
        }
    }

    /**
     * Tambah produk ke cart. Jika produk sudah ada, quantity ditambah.
     */
    public function add(Request $request)
    {
        $request->validate([
            'products_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1',
        ]);

        try {
            $cart = Cart::where('users_id', Auth::id())
                ->where('products_id', $request->products_id)
                ->first();

            if ($cart) {
                $cart->quantity += $request->input('quantity', 1);
                $cart->save();
            } else {
                $cart = Cart::create([
                    'users_id' => Auth::id(),
                    'products_id' => $request->products_id,
                    'quantity' => $request->input('quantity', 1),
                ]);
            }

            return ResponseFormatter::success(
                $cart->load('product'),
                'Produk berhasil ditambahkan ke cart'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan pada server', 500);
        }
    }

    /**
     * Update quantity item di cart.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $cart = Cart::where('id', $id)
                ->where('users_id', Auth::id())
                ->first();

            if (!$cart) {
                return ResponseFormatter::error(null, 'Item cart tidak ditemukan', 404);
            }

            $cart->quantity = $request->quantity;
            $cart->save();

            return ResponseFormatter::success(
                $cart->load('product'),
                'Cart berhasil diupdate'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan pada server', 500);
        }
    }

    /**
     * Hapus item dari cart.
     */
    public function remove($id)
    {
        try {
            $cart = Cart::where('id', $id)
                ->where('users_id', Auth::id())
                ->first();

            if (!$cart) {
                return ResponseFormatter::error(null, 'Item cart tidak ditemukan', 404);
            }

            $cart->delete();

            return ResponseFormatter::success(null, 'Item berhasil dihapus dari cart');
        } catch (Exception $error) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan pada server', 500);
        }
    }

    /**
     * Kosongkan semua item di cart user.
     */
    public function clear()
    {
        try {
            Cart::where('users_id', Auth::id())->delete();

            return ResponseFormatter::success(null, 'Cart berhasil dikosongkan');
        } catch (Exception $error) {
            return ResponseFormatter::error(null, 'Terjadi kesalahan pada server', 500);
        }
    }
}
