<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;


use Illuminate\Database\Eloquent\Model;


class spendings extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'spending_name',
        'description',
        'spending_value',
        'month',
        'section_id',
    ];

   public function section()
   {
   return $this->belongsTo('App\Models\section','section_id');
   }






}
