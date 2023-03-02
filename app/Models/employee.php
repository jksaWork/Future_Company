<?php

namespace App\Models;

use App\Traits\HasStatus;
use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;


class employee extends Model
{
    use HasStatus;
    use SoftDeletes;
    protected $guarded = [];

    /**
     * Class constructor.
     */

   public function Categorys()
   {
   return $this->belongsTo('App\Models\Category','categories_id');
   }

   public function employee_allowances()
    {

        return $this->belongsTo(employee_allowances::class ,'allowances_id');

    }
    public function allowances()
    {
        return $this->belongsTo(allowances::class ,'allowances_id');
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
