<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlantMeth;

class PlantMethodController extends Controller
{
    public function __construct()
    {
        $this->middleware('expert');
        //$this->mmsuqms = config('app.mmsuqms');
    }
    public function index()
    {
        $det = PlantMeth::join('plant_name', 'plant_name.id', '=', 'plant_methods.name_id')
            ->join('plant_variety', 'plant_variety.id', '=', 'plant_methods.variety_id')
            ->join('graft_details', 'graft_details.id', '=', 'plant_methods.graft_id')
            ->select([
                'plant_methods.id',
                'plant_name.name',
                'plant_name.description',
                'graft_details.title as g_title',
                'graft_details.description as g_description',
                'plant_variety.description as variety'
            ])->get();

        return $det;
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
                'variety_id' => 'required',
                //'description' => 'required',
            ],
            [
                'name_id.required' => 'Name field is required.',
                'graft_id.required' => 'Graft field is required',
                'variety_id.required' => 'Variety field is required!'
            ]
        );

        $m = new PlantMeth();

        $m->name_id = $request->name_id;
        $m->variety_id = $request->variety_id;
        $m->graft_id = $request->graft_id;
        //$m->description = $request->description;

        $m->save();

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

    public function destroy($id)
    {
        //
    }
}