<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantDet extends Model
{
    //use HasFactory;
    protected $table = 'plant_det';
    public $timestamps = false;

    public function puto()
    {
        return $this->hasOne(PlantPhoto::class, 'plant_det_id', 'id');
    }
}
