<?php

namespace App\Http\Controllers\PublicUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class PublicUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('pubuser');
        //$this->mmsuqms = config('app.mmsuqms');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}
