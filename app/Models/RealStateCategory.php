<?php

namespace App\Models;

use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealStateCategory extends Model
{
    use HasFactory, HasStatus;
    public const TYPES = ['sale' , 'rent'];
    public $fillable = ['type' , 'name' , 'status'];
}


