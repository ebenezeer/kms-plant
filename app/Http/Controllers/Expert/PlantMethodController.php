<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlantMeth;
use App\Models\GraftDetail;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use DB;

class PlantMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('expert');
        //$this->mmsuqms = config('app.mmsuqms');
    }

    public function index()
    {

        $user = Auth::user()->id;
        $det = PlantMeth::join('plant_det', 'plant_det.id', '=', 'methods_details.plant_det_id')
            ->join('plant_name', 'plant_name.id', '=', 'plant_det.name_id')
            ->join('plant_variety', 'plant_variety.id', '=', 'plant_det.variety_id')
            ->select([
                'methods_details.id',
                'plant_name.name',
                'plant_det.description',
                'plant_variety.description as variety'
            ])->get();

        return $det;
    }

    public function view_plant_methods($id)
    {
        $user = Auth::user()->id;
        $det = PlantMeth::where('methods_details.id', $id)
            ->join('plant_det', 'plant_det.id', '=', 'methods_details.plant_det_id')
            ->join('plant_name', 'plant_name.id', '=', 'plant_det.name_id')
            ->join('plant_variety', 'plant_variety.id', '=', 'plant_det.variety_id')
            ->select([
                'methods_details.*',
                'plant_name.name',
                'plant_det.description',
                'plant_variety.description as variety'
            ])->first();

        $mg = DB::table('methods_grafts')->where('meth_detail_id', $id)->get();

        $c = DB::table('article_comment')->where('article_comment.meth_detail_id', $det->id)->where('article_comment.active', 1)
            ->leftJoin('users', 'users.id', '=', 'article_comment.user_id')
            ->select([
                'article_comment.*',
                'users.name'
            ])->orderBy('article_comment.created_at', 'DESC')->get();

        // $det['comments'] = $c;
        $det['user_id'] = $user;
        //return $c;

        foreach ($mg as $gi) {
            $graft_ids[] = $gi->graft_id;
        }

        $grafts = GraftDetail::whereIn('id', $graft_ids)->with(['files'])->get();

        return response()->json([
            'plant_det' => $det,
            'meths' => $grafts,
            'comments' => $c
        ], 200);
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

    public function discard_comment(Request $request)
    {

        $id = $request->comment_id;

        $c = Comment::find($id);

        $c->active = 2;

        $c->save();

        return response()->json([
            'status'    => 1,
            'message'   => 'Successfully remove.'
        ], 200);
    }
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name_id' => 'required',
                'graft_id' => 'required',
                //'description' => 'required',
            ],
            [
                'name_id.required' => 'Name field is required.',
                'graft_id.required' => 'Graft field is required',

            ]
        );
        //return;
        $g = $request->graft_id;

        $m = new PlantMeth();

        $m->plant_det_id = $request->name_id;
        $m->search_key = $request->search_keys;

        $m->save();

        foreach ($g as $val) {
            DB::table('methods_grafts')->insert([
                'meth_detail_id' => $m->id, 'graft_id' => $val
            ]);
        }


        return response()->json([
            'gd'    => $m,
            'message'   => 'Successfully Recorded'
        ], 200);
    }
    public function update(Request $request, $id)
    {
        $p = PlantMeth::find($id);

        $p->search_key = $request->search_key;

        $p->save();

        return response()->json([
            'message'   => 'Successfully Updated'
        ], 200);
    }

    public function get_plant_names()
    {
        $det = DB::table('plant_det')->join('plant_name', 'plant_name.id', '=', 'plant_det.name_id')
            ->join('plant_variety', 'plant_variety.id', '=', 'plant_det.variety_id')
            ->select([
                'plant_det.*',
                'plant_name.name',
                'plant_variety.description as variety'
            ])
            //->orderBy('description')
            ->get();


        return $det;
    }
    public function destroy($id)
    {
        $d = PlantMeth::find($id);

        DB::table('methods_grafts')->where('meth_detail_id', $id)->delete();
        // foreach ($bid->files as $doc) {
        //     $doc->delete();
        // }
        // Storage::disk('public')->deleteDirectory('/uploads/' . $id);
        $d->delete();

        return 1;
    }
}
