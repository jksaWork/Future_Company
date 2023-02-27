<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;


use Illuminate\Database\Eloquent\Model;


class employee_allowances extends Model
{
    protected $guarded = [];

   public function Allowances_id()
   {
   return $this->belongsTo('App\Models\allowances','allowances_id');
   }

   public function employee()
   {
   return $this->belongsTo('App\Models\employee','employee_id');
   }



}
