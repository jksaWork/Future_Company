<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;


class school_spendings extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    // protected $fillable = [
    //     'spending_name',
    //     'description',
    //     'spending_value',
    //     'month',
    //     'section_id',
    //     'Transaction_id',
    //     'school_id',
    // ];

   public function section()
   {
   return $this->belongsTo('App\Models\school_sections','section_id');
   }

   public function School()
    {
    return $this->belongsTo('App\Models\school_types','school_id');
    }







}
