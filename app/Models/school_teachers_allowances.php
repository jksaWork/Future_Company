<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;


use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class school_teachers_allowances extends Model
{

    use SoftDeletes;
    protected $guarded = [];

   public function Allowances_id()
   {
   return $this->belongsTo('App\Models\School_allowances','allowances_id');
   }

   public function teachers()
   {
   return $this->belongsTo('App\Models\school_teachers','teachers_id');
   }
   public function School()
   {
   return $this->belongsTo('App\Models\school_types','school_id');
   }


}
