<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    function index(Request $request)
    {
        return view('contact');
    }
}
