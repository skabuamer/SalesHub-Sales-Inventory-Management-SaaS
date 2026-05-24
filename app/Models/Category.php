<?php

namespace App\Models;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'user_id'];

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function products()
    {
        return $this->hasMany(Product::class);
    }
}
