<?php

namespace App\Models;

use App\Traits\HasStatus;
use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;


class school_teachers extends Model
{
    use HasStatus;
    use SoftDeletes;
    protected $guarded = [];

    /**
     * Class constructor.
     */
    public function School()
    {
    return $this->belongsTo('App\Models\school_types','school_id');
    }

   public function Categorys()
   {
   return $this->belongsTo('App\Models\school_categories','categories_id');
   }

   public function teachers_allowances()
    {

        return $this->belongsTo(School_Teachers_allowances::class ,'allowances_id');

    }
    public function allowances()
    {
        return $this->belongsTo(School_allowances::class ,'allowances_id');
    }


    public function Advances()
    {
        return $this->hasMany(School_Advances::class);

    }
   public function getActive(){
    return   $this -> status == 1 ? 'مفعل'  : 'غير مفعل';
  }
  public function images()
  {
      return $this->hasMany(school_images::class);

  }

}
