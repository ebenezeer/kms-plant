<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantDet;
use App\Models\PhotoPlant;
use App\Models\PlantName;
use App\Models\PlantMeth;
use App\Models\GraftDetail;
use App\Models\MethodGraft;
use App\Models\Comment;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use DB;

class PublicController extends Controller
{
    public function public_index()
    {
        return view('welcome');
    }
    public function save_comment(Request $request)
    {
        $this->validate($request, [
            'comment' => 'required',

        ]);

        // $user = Auth::check();
        if (Auth::user()) {   // Check is user logged in
            $user = Auth::user()->id;
            // return 'log in true';
        } else {
            $user = 0;
            //  return "not login";
        }
        //Auth::user()->id;

        //return $user;

        $c = new Comment();

        $c->user_id = $user;
        $c->meth_detail_id = $request->article_id;
        $c->comment = $request->comment;

        $c->save();

        return response()->json([
            'message'   => 'Comment Successfully posted'
        ], 200);
    }
    public function plants_home()
    {
        $det = PlantDet::join('plant_name', 'plant_name.id', '=', 'plant_det.name_id')
            ->join('plant_variety', 'plant_variety.id', '=', 'plant_det.variety_id')
            ->select([
                'plant_det.*',
                'plant_name.name',
                'plant_variety.description as variety'
            ])->get();

        $a = [];
        foreach ($det as $d) {
            $p = PhotoPlant::where('plant_det_id', $d->id)->first();
            $a[] = [
                'id' => $d->id,
                'name_id' => $d->name_id,
                'variety_id' => $d->variety_id,
                'description' => $d->description,
                'name' => $d->name,
                'variety' => $d->variety,
                'puto' => $p,
                'updated_at' => $d->updated_at
            ];
        }

        return $a;
    }

    public function get_videos()
    {
        $v = GraftDetail::whereNotNull('vid_src')->get();
        return $v;
    }

    public function plant_show($id)
    {
        //return 'sdfsdfdsfsdfdsf';
        $d = PlantDet::where('plant_det.id', $id)->join('plant_name', 'plant_name.id', '=', 'plant_det.name_id')
            ->join('plant_variety', 'plant_variety.id', '=', 'plant_det.variety_id')
            //->leftJoin('plant_variety', 'plant_variety.id', '=', 'plant_det.variety_id')
            ->select([
                'plant_det.*',
                'plant_name.name',
                'plant_variety.description as variety'
            ])->first();


        $t = [];
        $gd = [];
        $c = null;
        $article_id = null;

        $md = PlantMeth::where('plant_det_id', $id)->first();
        // return $md;
        if ($md) {
            $mg = DB::table('methods_grafts')->where('meth_detail_id', $md->id)->get();
            $article_id = $md->id;
            foreach ($mg as $de) {
                // $gd = GraftDetail::where('id', $d->graft_id)->with(['files'])->get();

                $t[] = $de->graft_id;
            }
            $gd = GraftDetail::whereIn('id', $t)->with(['files'])->get();

            $c = DB::table('article_comment')->where('article_comment.meth_detail_id', $md->id)->where('article_comment.active', 1)
                ->leftJoin('users', 'users.id', '=', 'article_comment.user_id')
                ->select([
                    'article_comment.*',
                    'users.name',
                    'users.role'
                ])->orderBy('article_comment.created_at', 'DESC')->get();
        }

        // $a = [];
        //foreach ($det as $d) {
        $p = PhotoPlant::where('plant_det_id', $d->id)->first();
        $a = [
            'id' => $d->id,
            'name_id' => $d->name_id,
            'article_id' =>   $article_id,
            'variety_id' => $d->variety_id,
            'description' => $d->description,
            'name' => $d->name,
            'variety' => $d->variety,
            'puto' => $p,
            'tech' => $gd,
            'comments' => $c,
            'updated_at' => $d->updated_at
        ];
        // }

        return $a;
    }

    public function index_methods()
    {
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

        $det = PlantMeth::where('methods_details.id', $id)
            ->join('plant_det', 'plant_det.id', '=', 'methods_details.plant_det_id')
            ->join('plant_name', 'plant_name.id', '=', 'plant_det.name_id')
            ->join('plant_variety', 'plant_variety.id', '=', 'plant_det.variety_id')
            ->select([
                'methods_details.id',
                'plant_name.name',
                'plant_det.description',
                'plant_variety.description as variety'
            ])->first();

        $mg = DB::table('methods_grafts')->where('meth_detail_id', $id)->get();

        foreach ($mg as $gi) {
            $graft_ids[] = $gi->graft_id;
        }

        $grafts = GraftDetail::whereIn('id', $graft_ids)->with(['files'])->get();

        return response()->json([
            'plant_det' => $det,
            'meths' => $grafts
        ], 200);
    }
    public function search_engine(Request $request)
    {
        $search = $request->phrase;

        $posts = PlantMeth::join('plant_det', 'plant_det.id', '=', 'methods_details.plant_det_id')
            ->join('plant_name', 'plant_name.id', '=', 'plant_det.name_id')
            ->join('plant_variety', 'plant_variety.id', '=', 'plant_det.variety_id')
            ->where('methods_details.search_key', 'LIKE', "%{$search}%")
            ->orWhere('plant_name.name', 'LIKE', "%{$search}%")
            ->orWhere('plant_det.description', 'LIKE', "%{$search}%")
            ->orWhere('plant_variety.description', 'LIKE', "%{$search}%")
            ->orWhereHas('grafts.graft', function ($q) use ($search) {
                return $q->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('advantage', 'LIKE', '%' . $search . '%')
                    ->orWhere('disadvantage', 'LIKE', '%' . $search . '%')
                    ->orWhere('season', 'LIKE', '%' . $search . '%')
                    ->orWhere('pre_treatment', 'LIKE', '%' . $search . '%')
                    ->orWhere('post_treatment', 'LIKE', '%' . $search . '%');
            })
            ->select([
                'methods_details.id',
                'plant_name.name AS plant_name',
                'plant_det.id AS plant_det_id',
                'plant_det.description AS plant_des',
                'plant_variety.description AS variety',

            ])
            ->get();

        $result = [];
        $meth_ids = [];
        foreach ($posts as $p) {
            $a[] = [
                'plant_det_id' => $p->plant_det_id,
                'plant_name' => $p->plant_name,
                'variety' => $p->variety,
                'plant_des' => $p->plant_des,
            ];

            array_push($meth_ids, $p->id);
            # code...
        }

        //return $meth_ids;

        $mg = MethodGraft::whereIn('meth_detail_id', $meth_ids)->with(['graft'])->groupBy('graft_id')->get();


        return response()->json([
            'plants'   => $posts,
            'grafts'   => $mg
        ], 200);
    }
    public function graft_tech($id)
    {
        $g = GraftDetail::where('id', $id)->with(['files'])->get();
        return $g;
    }
}