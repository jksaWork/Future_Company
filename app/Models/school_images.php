<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class school_images extends Model
{
    public $fillable= ['filename','imageable_id','imageable_type'];
    public function teachers()
    {
    return $this->belongsTo('App\Models\school_teachers','imageable_id');
    }
    public function imageable()
    {
        return $this->morphTo();
    }
}
