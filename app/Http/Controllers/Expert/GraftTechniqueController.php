<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlantName;
use App\Models\GraftDetail;
use App\Models\PhotoGraft;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GraftTechniqueController extends Controller
{
    public function __construct()
    {
        $this->middleware('expert');
        //$this->mmsuqms = config('app.mmsuqms');
    }
    public function index()
    {
        $graftings = GraftDetail::orderBy('title')->get();

        return $graftings;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',

        ]);

        $gd = new GraftDetail();

        $gd->title = $request->title;
        $gd->description = $request->description;
        $gd->advantage = $request->advantage;
        $gd->disadvantage = $request->disadvantage;

        $gd->save();

        return response()->json([
            'gd'    => $gd,
            'message'   => 'Successfully Recorded'
        ], 200);
    }

    public function updateDocs(Request $request, $id)
    {
        $file = $request->docs;
        $filename = $file->getClientOriginalName();
        $f_hash = md5($filename . time()) . '.' . $file->extension();

        if (Storage::disk('public')->put('uploads/' . $id . '/' . $f_hash,  File::get($file))) {
            $f = new PhotoGraft();
            $f->graft_detail_id = $id;
            $f->name = $filename;
            $f->file_name = $f_hash;
            $f->src = '/uploads/' . $id . '/' . $f_hash;
            $f->save();

            return response()->json([
                'success' => true,
                'id' => $f->id
            ], 200);
        }

        return response()->json([
            'success' => false
        ], 500);
    }

    public function deleteDoc($id)
    {
        $doc = PhotoGraft::find($id);
        Storage::disk('public')->delete($doc->src);
        $doc->delete();

        return 1;
    }

    public function show($id)
    {
        $g = GraftDetail::findOrFail($id);


        $g_files = PhotoGraft::where('graft_detail_id', $id)->get();

        $data = [
            'id' => $g->id,
            'title' => $g->title,
            'description' => $g->description,
            'advantage' => $g->advantage,
            'disadvantage' => $g->disadvantage,
            'vid_src' => $g->vid_src,
            'docs' => $g_files
        ];

        return $data;
    }


    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $g = GraftDetail::find($id);
        $g->title = $request->title;
        $g->description = $request->description;
        $g->advantage = $request->advantage;
        $g->disadvantage = $request->disadvantage;
        $g->vid_src = $request->vid_src;

        $g->save();

        return 1;
    }

    public function destroy($id)
    {
        //
    }
}