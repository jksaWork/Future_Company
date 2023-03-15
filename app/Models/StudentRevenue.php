<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentRevenue extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public function scopetypeScope($query)
    {
        $query->when(request()->type != null, function ($q) {
            return $q->where('revenue_type', request()->type);
        });
    }

    public function School()
    {
        return $this->belongsTo(Owner::class, 'school_id');
    }
}