<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    function index(Request $request)
    {
        return view('about');
    }
}
