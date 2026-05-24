<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    function createCategory(Request $request)
    {
        $user_id = $request->header('userId');
        $request->validate([
            'name' => 'required',
        ]);

        Category::create([
            'name' => $request->name,
            'user_id' => $user_id
        ]);

        return redirect()->back()->with([
            'status' => 'success',
            'message' => 'Category created successfully, Check Categories page to view',
        ]);
    }

    // read
    function categories(Request $request)
    {
        $user_id = $request->header('userId');

        $categories = Category::where('user_id', $user_id)->get();

        return Inertia::render('Categories', [
            'categories' => $categories,
        ]);
    }


    // single method for create and update
    function categorySavePage(Request $request)
    {
        $categiry_id = $request->query('id');
        $user_id = $request->header('userId');

        $category = Category::where('user_id', $user_id)->where('id', $categiry_id)->first();
        return Inertia::render('CategorySavePage', [
            'category' => $category,
        ]);
    }

    // product by id - param id
    function category(Request $request, $id)
    {
        $user_id = $request->header('userId');
        $category = Category::where('user_id', $user_id)->where('id', $id)->with('products')->first();
        return $category;
    }

    // product by id - json body id -post route
    // function category(Request $request)
    // {
    //     $user_id = $request->header('userId');
    //     $categories = Category::where('user_id', $user_id)->where('id', $request->id)->with('products')->get();
    //     return $category;
    // }

    // update
    function updateCategory(Request $request, $id)
    {
        $user_id = $request->header('userId');
        $request->validate([
            'name' => 'required',
        ]);

        Category::where('user_id', $user_id)->where('id', $id)->update([
            'name' => $request->name,
        ]);

        return redirect()->route('category.index')->with([
            'status' => 'success',
            'message' => 'Category updated successfully',
        ]);
    }

    // delete 
    function deleteCategory(Request $request, $id)
    {
        $user_id = $request->header('userId');

        $category = Category::where('user_id', $user_id)->where('id', $id)->findOrFail($id);

        if ($category->products()->exists()) {
            return redirect()->back()->with([
                'error' => 'To delete this category, you need to delete its products first, otherwise category cannot be deleted.'
            ]);
        }

        $category->delete();

        return redirect()->route('category.index')->with([
            'status' => 'success',
            'message' => 'Category deleted successfully',
        ]);
    }
}
