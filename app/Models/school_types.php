<?php

namespace App\Models;
// use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class school_types extends Model
{
    use SoftDeletes;
    protected $guarded =[];

    // relation Category With His teachers If Has teachers

    public function teachers()
    {
        return $this->hasMany(teachers::class);

    }//end of teachers
}
