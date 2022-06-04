<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;


class AdministratorController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
        //$this->mmsuqms = config('app.mmsuqms');
    }
    public function user_details()
    {
        $user = Auth::user()->name;

        return strtoupper($user);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
