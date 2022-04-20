<?php

namespace App\Http\Controllers\PublicUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function __construct()
    {
        $this->middleware('userview');
        //$this->mmsuqms = config('app.mmsuqms');
    }

    public function save_comment(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required',

        ]);

        $user = Auth::user()->id;

        $c = new Comment();

        $c->user_id = $user;
        $c->meth_detail_id = $request->article_id;
        $c->comment = $request->comment;


        $c->save();

        return response()->json([
            'message'   => 'Comment Successfully posted'
        ], 200);
    }
}