<?php

namespace App\Models;

use App\Traits\HasSearchScope;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealStateCategory extends Model
{
    use HasFactory, HasStatus, HasSearchScope;
    public const TYPES = ['sale' , 'rent'];
    public $guarded = [];
}


