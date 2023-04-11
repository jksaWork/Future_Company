<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;

// use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;


class type_accounts extends Model
{
    // use SoftDeletes;
    protected $guarded = [];

  

   public function spendings()
    {
    return $this->belongsTo('App\Models\school_spendings','school_spendings_id');
    }







}
