<?php

namespace App\Models;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    protected $fillable = [
        'invoice_id',
        'product_id',
        'user_id',
        'qty',
        'sale_price'
    ];

    function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    function product()
    {
        return $this->belongsTo(Product::class);
    }

    function user()
    {
        return $this->belongsTo(User::class);
    }
}
