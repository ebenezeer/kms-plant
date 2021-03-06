<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $role = Auth::user()->role;
        if ($role == 1) {
            return redirect('/admin/home');
        }

        if ($role == 2) {
            return redirect('/expert/home');
        }

        if ($role == 3) {
            return redirect('/user-view/home');
        }
    }
}