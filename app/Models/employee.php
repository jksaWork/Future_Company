<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;


use Illuminate\Database\Eloquent\Model;


class employee extends Model
{
    protected $guarded = [];

   public function Categorys()
   {
   return $this->belongsTo('App\Models\Category','categories_id');
   }

   public function employee_allowances()
    {
        return $this->hasMany(employee_allowances::class);

    }

    public function Advances()
    {
        return $this->hasMany(Advances::class);

    }
   public function getActive(){
    return   $this -> status == 1 ? 'مفعل'  : 'غير مفعل';
  }
  public function images()
  {
      return $this->hasMany(Image::class);

  }

}
