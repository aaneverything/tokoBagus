<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_transaction';

    protected $fillable = [
        'users_id',
        'address',
        'payment',
        'total_price',
        'shipping_price',
        'status'
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(Transaction_items::class, 'transactions_id', 'id');
    }

    protected static function booted(): void
    {
        static::creating(function (self $model) {
            if (empty($model->users_id) && auth()->check()) {
                $model->users_id = auth()->id();
            }
        });
    }
}
