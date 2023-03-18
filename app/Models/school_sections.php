<?php

namespace App\Models;
// use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\SoftDeletes;
class school_sections extends Model
{
    use SoftDeletes;
   
    protected $guarded = [];
    // relation Category With His teachers If Has teachers

    public function teachers()
    {
        return $this->hasMany(teachers::class);

    }//end of teachers
    public function School()
    {
    return $this->belongsTo('App\Models\school_types','school_id');
    }
    public function school_type($query)
    {
        
        // if($query == null){
        return $query->where('school_id', request()->section);
        
        
    // }
    }
}
