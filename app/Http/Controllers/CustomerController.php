<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller
{

    function createCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $user_id = $request->header('userId');

        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_id' => $user_id
        ]);

        return back()->with([
            'status' => 'success',
            'message' => 'Customer created successfully. Check Customers page to view.'
        ]);
    }

    // read
    function customers(Request $request)
    {
        $user_id = $request->header('userId');

        $customers = Customer::where('user_id', $user_id)->get();


        return Inertia::render('Customers', [
            'customers' => $customers
        ]);
    }


    function customerSavePage(Request $request)
    {
        $customer_id = $request->query('id');
        $user_id = $request->header('userId');

        $customer = Customer::where('user_id', $user_id)->where('id', $customer_id)->first();
        return Inertia::render('CustomerSavePage', [
            'category' => $customer,
        ]);
    }

    // product by id - param id
    function customer(Request $request, $id)
    {
        $user_id = $request->header('userId');
        $customer = Customer::where('user_id', $user_id)->where('id', $id)->first();
        return $customer;
    }

    // update
    function updateCustomer(Request $request, $id)
    {
        $user_id = $request->header('userId');

        Customer::where('user_id', $user_id)->where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('customer.index')->with([
            'status' => 'success',
            'message' => 'Customer updated successfully.'
        ]);
    }

    // delete 
    function deleteCustomer(Request $request, $id)
    {
        $user_id = $request->header('userId');

        $customer = Customer::where('user_id', $user_id)->where('id', $id)->findOrFail($id);

        if ($customer->invoices()->exists()) {

            return back()->with([
                'error' => 'To delete this customer, you need to delete his invoice first, otherwise customer cannot be deleted.'
            ]);
        }

        $customer->delete();

        return back()->with([
            'message' => 'Customer deleted successfully.'
        ]);
    }
}
