<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlantMeth;
use App\Models\GraftDetail;
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

    public function create()
    {
        //
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
        //$m->graft_id = $request->graft_id;

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

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
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
        //
    }
}
