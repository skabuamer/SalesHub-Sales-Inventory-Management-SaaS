<?php

namespace App\Models;

use App\Models\InvoiceProduct;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'unit',
        'img',
        'user_id',
        'category_id',
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function category()
    {
        return $this->belongsTo(Category::class);
    }


    function invoiceProducts()
    {
        return $this->hasMany(InvoiceProduct::class);
    }
}
