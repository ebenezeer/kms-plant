<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantMeth extends Model
{
    //use HasFactory;
    protected $table = 'methods_details';
    public $timestamps = false;

    public function grafts()
    {
        return $this->hasMany(MethodGraft::class, 'meth_detail_id', 'id');
    }
}
