<?php

namespace App\Models;
// use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\SoftDeletes;
class section extends Model
{
    use SoftDeletes;
    protected $guarded =[];

    // relation Category With His Employee If Has Employee

    public function Employee()
    {
        return $this->hasMany(Employee::class);

    }//end of Employee
}
