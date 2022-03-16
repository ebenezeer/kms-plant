<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ExpertController extends Controller
{
    public function __construct(){
        $this->middleware('expert');
        //$this->mmsuqms = config('app.mmsuqms');
    }
    public function logout(Request $request){
        Auth::logout();
        return redirect('/login');
    }
}
