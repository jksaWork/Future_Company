<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;


use Illuminate\Database\Eloquent\Model;


class employee extends Model
{
    protected $guarded = [];

   public function Category()
   {
   return $this->belongsTo('App\Models\Category');
   }
   public function getActive(){
    return   $this -> active == 1 ? 'مفعل'  : 'غير مفعل';
  }

}
