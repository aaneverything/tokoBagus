<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'categories_id',
        'tags'
    ];

    public function galleries()
    {
        return $this->hasMany(Product_gallery::class, 'products_id', 'id');
    }

    public function category(){
        return $this->belongsTo(Product_Category::class, 'categories_id', 'id');
    }

    public function transactionItem(){
        return $this->hasMany(Transaction_items::class, 'products_id', 'id');
    }
}
