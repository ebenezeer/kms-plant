<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraftDetail extends Model
{
    //use HasFactory;
    protected $table = 'graft_details';
    public $timestamps = false;

    public function files()
    {
        return $this->hasMany(PhotoGraft::class, 'graft_detail_id', 'id');
    }
}