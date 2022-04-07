<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantDet;
use App\Models\PhotoPlant;
use App\Models\PlantName;
use App\Models\PlantMeth;
use App\Models\GraftDetail;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use DB;

class PublicController extends Controller
{
    public function public_index()
    {
        return view('welcome');
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

        $md = PlantMeth::where('plant_det_id', $id)->first();

        $mg = DB::table('methods_grafts')->where('meth_detail_id', $md->id)->get();
        $t = [];
        $gd = [];

        foreach ($mg as $de) {
            // $gd = GraftDetail::where('id', $d->graft_id)->with(['files'])->get();

            $t[] = $de->graft_id;
        }
        $gd = GraftDetail::whereIn('id', $t)->with(['files'])->get();

        // $a = [];
        //foreach ($det as $d) {
        $p = PhotoPlant::where('plant_det_id', $d->id)->first();
        $a = [
            'id' => $d->id,
            'name_id' => $d->name_id,
            'variety_id' => $d->variety_id,
            'description' => $d->description,
            'name' => $d->name,
            'variety' => $d->variety,
            'puto' => $p,
            'tech' => $gd,
            'updated_at' => $d->updated_at
        ];
        // }

        return $a;
    }
}