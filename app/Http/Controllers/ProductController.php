<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    // create
    function createProduct(Request $request)
    {
        $user_id = $request->header('userId');

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'unit' => 'required',
            'category_id' => 'required',
            'img' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'unit' => $request->unit,
            'user_id' => $user_id,
            'category_id' => $request->category_id,
        ];

        if ($request->hasFile('img')) {
            $image = $request->file('img');

            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $filePath = 'uploads/' . $fileName;

            $image->move(public_path('uploads'), $fileName);

            $data['img'] = $filePath;
        }

        Product::create($data);

        return back()->with([
            'status' => 'success',
            'message' => 'Product Created successfully.'
        ]);
    }

    // list
    function products(Request $request)
    {
        $user_id = $request->header('userId');

        $products = Product::where('user_id', $user_id)->with('category')->latest()->get();

        return Inertia::render('Products', [
            'products' => $products,
        ]);
    }


    // save page
    function productSavePage(Request $request)
    {
        $product_id = $request->query('id');
        $user_id = $request->header('userId');

        $product = Product::where('user_id', $user_id)->where('id', $product_id)->first();
        $categories = Category::where('user_id', $user_id)->get();

        return Inertia::render('ProductSavePage', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    // by id
    function product(Request $request, $id)
    {
        $user_id = $request->header('userId');
        $product = Product::where('user_id', $user_id)->where('id', $id)->first();
        return $product;
    }


    function updateProduct(Request $request, $id)
    {
        $user_id = $request->header('userId');

        $request->validate([
            'category_id' => 'required',
            'name' => 'required',
            'price' => 'required',
            'unit' => 'required',
        ]);

        $product = Product::where('user_id', $user_id)->where('id', $id)->findOrFail($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->unit = $request->unit;
        $product->category_id = $request->category_id;


        if ($request->hasFile('img')) {

            if ($product->img && file_exists(public_path($product->img))) {
                unlink(public_path($product->img)); // removing the existing data from file if it already exist
            }

            $request->validate([
                'img' => 'image|mimes:jpg,jpeg,png,svg,webp|max:2048',
            ]);

            $image = $request->file('img');

            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $filePath = 'uploads/' . $fileName;

            $image->move(public_path('uploads'), $fileName);

            $product->img = $filePath; //updating the data
        }

        $product->save();

        return redirect()->route('product.index')->with([
            'status' => 'success',
            'message' => 'Product Updated successfully.',
            'error' => ''
        ]);
    }

    function deleteProduct(Request $request, $id)
    {
        try {
            $user_id = $request->header('userId');
            $product = Product::where('user_id', $user_id)->where('id', $id)->findOrFail($id);


            if ($product->invoiceProducts()->exists()) {
                return redirect()->route('product.index')->with([
                    'status' => 'failed',
                    'error' => 'To delete this product, you need to delete its invoice first.',
                ]);
            }

            if ($product->img && file_exists(public_path($product->img))) {
                unlink(public_path($product->img));
            }

            $product->delete();

            return redirect()->route('product.index')->with([
                'status' => 'success',
                'message' => 'Product deleted successfully',
            ]);
        } catch (Exception $e) {
            return redirect()->route('product.index')->with([
                'status' => 'failed',
                'error' => 'Something went wrong, please try again.',
            ]);
        }
    }
}
