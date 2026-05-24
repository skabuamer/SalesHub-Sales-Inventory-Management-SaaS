<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    function dashboard(Request $request)
    {
        $user = $request->headers->get('email');
        $user_id = $request->header('userId');

        $userData = User::where('email', $user)->select('name')->first();
        $products = Product::where('user_id', $user_id)->count();
        $customers = Customer::where('user_id', $user_id)->count();
        $sales = InvoiceProduct::where('user_id', $user_id)->sum('qty');
        $payable = Invoice::where('user_id', $user_id)->sum('payable');

        $data = [
            'products' => $products,
            'customers' => $customers,
            'sales' => $sales,
            'payable' => $payable,
        ];

        return Inertia::render('Dashboard', [
            'data' => $data,
            'user' => $userData,
        ]);
    }
}
