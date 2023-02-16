<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;


use Illuminate\Database\Eloquent\Model;


class Advances extends Model
{
    protected $guarded = [];

   public function employee()
   {
   return $this->belongsTo('App\Models\employee','employee_id');
   }


}
