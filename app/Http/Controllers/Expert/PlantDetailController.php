<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlantName;

class PlantDetailController extends Controller
{
    public function __construct()
    {
        $this->middleware('expert');
        //$this->mmsuqms = config('app.mmsuqms');
    }

    public function get_plant_names()
    {
        $units = PlantName::orderBy('name')->get();

        return $units;
    }
}
