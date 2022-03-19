<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlantName;

class PlantNameController extends Controller
{
    public function __construct()
    {
        $this->middleware('expert');
    }
    public function index()
    {
        $units = PlantName::orderBy('name')->get();

        return $units;
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
            'name' => 'required',

        ]);

        $unit = new PlantName();

        $unit->name = $request->name;


        $unit->save();

        return response()->json([
            'unit'    => $unit,
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
        $this->validate($request, [
            'name' => 'required'
        ]);

        $unit = PlantName::find($id);

        $unit->name = $request->name;

        $unit->save();

        return response()->json([
            'unit'    => $unit,
            'message'   => 'Successfully Recorded'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
