<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\InvoiceProduct;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'total',
        'discount',
        'vat',
        'payable',
        'user_id',
        'customer_id'
    ];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    function invoiceProducts()
    {
        return $this->hasMany(InvoiceProduct::class);
    }
}
