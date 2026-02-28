<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Transaction_items;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@spp.com')->first();
        if (!$user) return;

        $products = Product::take(3)->get();
        if ($products->isEmpty()) return;

        // Transaksi 1: Pending
        $transaction1 = Transaction::updateOrCreate(
            ['id' => 1],
            [
                'users_id' => $user->id,
                'address' => 'Jl. Sudirman No. 10, Jakarta Pusat',
                'payment' => 'manual',
                'total_price' => $products[0]->price + $products[1]->price,
                'shipping_price' => 15000,
                'status' => 'pending',
            ]
        );

        Transaction_items::updateOrCreate(
            ['transactions_id' => $transaction1->id, 'products_id' => $products[0]->id],
            [
                'users_id' => $user->id,
                'products_id' => $products[0]->id,
                'transactions_id' => $transaction1->id,
                'quantity' => 1,
            ]
        );

        Transaction_items::updateOrCreate(
            ['transactions_id' => $transaction1->id, 'products_id' => $products[1]->id],
            [
                'users_id' => $user->id,
                'products_id' => $products[1]->id,
                'transactions_id' => $transaction1->id,
                'quantity' => 1,
            ]
        );

        // Transaksi 2: Success
        if (isset($products[2])) {
            $transaction2 = Transaction::updateOrCreate(
                ['id' => 2],
                [
                    'users_id' => $user->id,
                    'address' => 'Jl. Gatot Subroto No. 5, Jakarta Selatan',
                    'payment' => 'manual',
                    'total_price' => $products[2]->price * 2,
                    'shipping_price' => 20000,
                    'status' => 'success',
                ]
            );

            Transaction_items::updateOrCreate(
                ['transactions_id' => $transaction2->id, 'products_id' => $products[2]->id],
                [
                    'users_id' => $user->id,
                    'products_id' => $products[2]->id,
                    'transactions_id' => $transaction2->id,
                    'quantity' => 2,
                ]
            );
        }
    }
}
