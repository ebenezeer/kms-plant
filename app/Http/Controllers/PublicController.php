<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function public_index()
    {
        return view('layouts.public_layout');
    }
}