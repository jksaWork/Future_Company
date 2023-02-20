<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealstateInstallment extends Model
{
    use HasFactory;
    public $table = 'realstate_installment';
    public $gaurded = [];

    public function RealState(){
        return $this->belongsTo(RealState::class, 'realstate_id');
    }
    public function Owner(){
        return $this->belongsTo(RealState::class, 'owner_id');
    }
}