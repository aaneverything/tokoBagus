<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Transaction_items;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class transactionController extends Controller
{
    public function all(Request $request)
    {
        try {
            $id = $request->input('id');
            $limit = $request->input('limit');
            $status = $request->input('status');

            if ($id) {
                $transaction = Transaction::with(['items.product'])->find($id);
                if ($transaction) {
                    return ResponseFormatter::success($transaction, 'Data transaksi berhasil diambil');
                } else {
                    return ResponseFormatter::error(
                        null,
                        'Data transaksi tidak ditemukan',
                        404
                    );
                }
            }

            $transaction = Transaction::with(['items.product'])->where('users_id', Auth::id());

            if ($status) {
                $transaction->where('status', $status);
            }
            return ResponseFormatter::success(
                $transaction->paginate($limit),
                'data transaksi berhasil diambil'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error(
                null,
                'Terjadi kesalahan pada server',
                500
            );
        }
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'exists:products,id',
            'total_price' => 'required|numeric',
            'shipping_price' => 'required|numeric',
            'status' => 'required|in:pending,shipping,success,canceled,failed,shipped'
        ]);

        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'address' => $request->address,
            'total_price' => $request->total_price,
            'shipping_price' => $request->shipping_price,
            'status' => strtolower($request->status),
        ]);

        foreach ($request->items as $product) {
            Transaction_items::create([
                'users_id' => Auth::user()->id,
                'products_id' => $product['id'],
                'transactions_id' => $transaction->id,
                'quantity' => $product['quantity']
            ]);
        }

        return ResponseFormatter::success($transaction->load('items.product'), 'Checkout berhasil');
    }
}
