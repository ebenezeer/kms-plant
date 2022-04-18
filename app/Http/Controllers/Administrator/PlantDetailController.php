<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlantDet;
use App\Models\PhotoPlant;
use App\Models\PlantName;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PlantDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
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
            ];
        }

        return $a;
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

    public function updatePhoto(Request $request, $id)
    {
        $file = $request->docs;
        $filename = $file->getClientOriginalName();
        $f_hash = md5($filename . time()) . '.' . $file->extension();

        if (Storage::disk('public')->put('uploads/plant/' . $id . '/' . $f_hash,  File::get($file))) {
            $del = PhotoPlant::where('plant_det_id', $id)->first();
            if (!is_null($del)) {
                Storage::disk('public')->delete($del->src);
                $del->delete();
            }

            $f = new PhotoPlant();
            $f->plant_det_id = $id;
            $f->name = $filename;
            $f->file_name = $f_hash;
            $f->src = '/uploads/plant/' . $id . '/' . $f_hash;
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
    public function deletePhoto($id)
    {
        $doc = PhotoPlant::find($id);
        Storage::disk('public')->delete($doc->src);
        $doc->delete();

        return 1;
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
