<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SaleController extends Controller
{
    function sale(Request $request)
    {
        $user_id = $request->header('userId');

        $customers = Customer::where('user_id', $user_id)->get();
        $products = Product::where('user_id', $user_id)->get();

        return Inertia::render('SalePage', [
            'customers' => $customers,
            'products' => $products,
        ]);
    }
}
