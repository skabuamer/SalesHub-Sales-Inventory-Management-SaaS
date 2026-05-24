<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    function createInvoice(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'total' => 'required',
            'payable' => 'required',
            'products' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $user_id = $request->header('userId');

            $data = [
                'user_id' => $user_id,
                'customer_id' => $request->customer_id,
                'total' => $request->total,
                'vat' => $request->vat,
                'payable' => $request->payable,
                'discount' => $request->discount,
            ];

            $invoice = Invoice::create($data);

            $products = $request->products;

            foreach ($products as $product) {
                $existQty = Product::where('id', $product['id'])->first();

                if (!$existQty) {
                    return response()->json([
                        'status' => 'failed',
                        'message' => 'Product with ID ' . $product['id'] . ' not found',
                    ]);
                }

                if ($existQty->unit < $product['unit']) {
                    return response()->json([
                        'status' => 'failed',
                        'message' => "Only {$existQty->unit} Available of product with ID {$product['id']}"
                    ]);
                }

                InvoiceProduct::create([
                    'invoice_id' => $invoice->id,
                    'user_id' => $user_id,
                    'product_id' => $product['id'],
                    'qty' => $product['unit'],
                    'sale_price' => $product['price'],
                ]);

                Product::where('id', $product['id'])->update([
                    'unit' => $existQty->unit - $product['unit']
                ]);
            }

            Db::commit();
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Invoice created successfully',
            // ]);

            return back()->with([
                'status' => 'success',
                'message' => 'Sale Invoice created successfully',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            // return response()->json([
            //     'status' => 'failed',
            //     'message' => "Something Went Wrong!" . $e->getMessage(),
            // ]);
            return back()->with([
                'status' => 'failed',
                'message' => "Something Went Wrong!" . $e->getMessage(),
            ]);
        }
    }


    function invoices(Request $request)
    {
        $user_id = $request->header('userId');

        $invoices = Invoice::where('user_id', $user_id)->with('customer')->with('invoiceProducts.product')->get();

        return Inertia::render('Invoices', [
            'invoices' => $invoices,
        ]);
    }

    function invoiceDetails(Request $request)
    {
        $user_id = $request->header('userId');

        $customer = Customer::where('user_id', $user_id)->where('id', $request->customer_id)->first();
        $invoice = Invoice::where('user_id', $user_id)->where('id', $request->invoice_id)->first();
        $invoiceProducts = InvoiceProduct::where('invoice_id', $request->invoice_id)->where('user_id', $user_id)->with('product')->get();

        return response()->json([
            'customer' => $customer,
            'invoice' => $invoice,
            'invoiceProducts' => $invoiceProducts,
        ]);
    }

    function deleteInvoice(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $user_id = $request->header('userId');
            InvoiceProduct::where('invoice_id', $id)->where('user_id', $user_id)->delete();
            Invoice::where('user_id', $user_id)->where('id', $id)->delete();
            Db::commit();
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Invoice deleted successfully',
            // ]);
            return redirect()->route('invoices')->with([
                'status' => 'success',
                'message' => 'Invoice deleted successfully',
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'failed',
                'message' => 'Something went wrong',
            ]);
        }
    }
}
