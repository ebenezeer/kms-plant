<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Auth;

class ExpertController extends Controller
{
    public function __construct()
    {
        $this->middleware('expert');
        //$this->mmsuqms = config('app.mmsuqms');
    }
    public function user_details()
    {
        $user = Auth::user()->name;

        return strtoupper($user);
    }
    public function get_comments()
    {
        $c = Comment::join('methods_details', 'methods_details.id', '=', 'article_comment.meth_detail_id')
            ->join('plant_det', 'plant_det.id', '=', 'methods_details.plant_det_id')
            ->join('plant_name', 'plant_name.id', '=', 'plant_det.name_id')
            ->join('plant_variety', 'plant_variety.id', '=', 'plant_det.variety_id')
            ->leftJoin('users', 'users.id', '=', 'article_comment.user_id')
            ->select([
                'article_comment.*',
                'plant_name.name as plant',
                'plant_variety.description as variety',
                'users.name'
            ])
            ->get();
        return $c;
    }
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}