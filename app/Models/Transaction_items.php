<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction_items extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quantity',
        'users_id',
        'products_id',
        'transactions_id'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'users_id','id');
    }
    public function products(){
        return $this->hasMany(Product::class,'products_id', 'name');
    }
    public function transaction(){
        return $this->belongsTo(transaction::class, 'transaction_id','id');
    }

}
