<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentRevenue extends Model
{
    use HasFactory, SoftDeletes;

    public function scopetypeScope($query)
    {
        $query->when(request()->type != null, function ($q) {
            return $q->where('type', request()->type);
        });
    }
}