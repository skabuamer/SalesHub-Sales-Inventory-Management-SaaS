<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    //
    function index()
    {
        return redirect()->route('dashboard')->with([
            'status' => 'success',
            'message' => 'User logged in successfully',
            "error" => "",
        ]);
        // return Inertia::render('HomePage');
    }
}
