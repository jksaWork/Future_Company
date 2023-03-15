<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;


class school_advances extends Model
{
    
    use SoftDeletes;
    protected $guarded = [];

   public function teachers()
   {
   return $this->belongsTo('App\Models\school_teachers','teachers_id');
   }
   public function School()
  {
  return $this->belongsTo('App\Models\school_types','school_id');
  }


}
