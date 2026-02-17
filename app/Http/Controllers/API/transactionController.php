<?php

namespace App\Http\Controllers\API;

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
                    return ResponseFormatter::success($transaction, 'transaction berhasil diambil');
                } else {
                    return ResponseFormatter::error(
                        null,
                        'datanya gaada njirr',
                        404
                    );
                }
            }

            $transaction = Transaction::with(['items.product'])->where('user_id', Auth::user()->id);

            if ($status) {
                $transaction->where('status', $status);
            }
            return ResponseFormatter::success(
                $transaction->paginate($limit),
                'data transaksi berhasil diambil'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error(
                $error,
                'ada yang salah nich',
                404
            );
        }
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'exists:products.id',
            'total_price' => 'required',
            'shipping_price' => 'required',
            'status' => 'required|in:PENDING, SHIPPING, SUCCESS, CANCELED, FAILED, SHIPPED'
        ]);

        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'address' => $request->address,
            'total_price' => $request->total_price,
            'shipping_price' => $request->shipping_price,
            'status' => $request->status,
        ]);

        foreach ($request->items as $product) {
            Transaction_items::create([
                'users_id' => Auth::user()->id,
                'products_id' => $product['id'],
                'transactions_id' => $transaction->id,
                'quantity' => $product['quantity']
            ]);
        }

        return ResponseFormatter::success($transaction->load('items.product'), 'Transaksi berhasil anjay');
    }
}
