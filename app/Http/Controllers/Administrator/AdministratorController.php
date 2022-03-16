<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;


class AdministratorController extends Controller
{
    public function __construct(){
        $this->middleware('admin');
        //$this->mmsuqms = config('app.mmsuqms');
    }
    public function logout(Request $request){
        Auth::logout();
        return redirect('/login');
    }
}
