<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MethodGraft extends Model
{
    //use HasFactory;
    protected $table = 'methods_grafts';
    public $timestamps = false;

    public function graft()
    {
        return $this->hasOne(GraftDetail::class, 'id', 'graft_id');
    }
}
