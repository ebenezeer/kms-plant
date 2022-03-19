<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlantDet;
use App\Models\PlantName;

class PlantDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('expert');
        //$this->mmsuqms = config('app.mmsuqms');
    }
    public function index()
    {
        $det = PlantDet::join('plant_name', 'plant_name.id', '=', 'plant_det.name_id')
            ->join('plant_variety', 'plant_variety.id', '=', 'plant_det.variety_id')
            ->select([
                'plant_det.*',
                'plant_name.name',
                'plant_variety.description as variety'
            ])->get();

        return $det;
    }
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name_id' => 'required',
                'variety_id' => 'required',
                'description' => 'required',
            ],
            [
                'name_id.required' => 'Name field is required.',
                'variety_id.required' => 'Variety field is required!'
            ]
        );

        $m = new PlantDet();

        $m->name_id = $request->name_id;
        $m->variety_id = $request->variety_id;
        $m->description = $request->description;

        $m->save();

        return response()->json([
            'gd'    => $m,
            'message'   => 'Successfully Recorded'
        ], 200);
    }
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'variety_id' => 'required',
                'description' => 'required',
            ],
            [
                'variety_id.required' => 'Variety field is required!'
            ]
        );

        $unit = PlantDet::find($id);

        $unit->variety_id = $request->variety_id;
        $unit->description = $request->description;

        $unit->save();

        return response()->json([
            'unit'    => $unit,
            'message'   => 'Successfully Recorded'
        ], 200);
    }
    public function get_plant_names()
    {
        $units = PlantName::orderBy('name')->get();

        return $units;
    }
}