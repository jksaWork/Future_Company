<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;


use Illuminate\Database\Eloquent\Model;


class allowances extends Model
{
    protected $guarded = [];

   public function Categorys()
   {
   return $this->belongsTo('App\Models\Category','categories_id');
   }

   public function getActive(){
    return   $this -> status == 1 ? 'ثابت'  : 'غير ثابت';
  }


}
