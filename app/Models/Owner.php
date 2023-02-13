<?php

namespace App\Models;

use App\Traits\HasSearchScope;
use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Owner extends Authenticatable
{
    use HasFactory , HasApiTokens , HasSearchScope , HasStatus;
    protected $guarded =[];

    // relation Owners With His Agent If Has Agent
    public function Agent(){
        return $this->belongsTo(Agent::class);
    }
    public function RealState():HasMany
    {
        return $this->hasMany(User::class, 'id');
    }

    // Scopes When Agent User Is Usgin
    public function scopeWhenAgentUser($q){
        if(auth()->guard('web')->check()){
            return $q->where('agent_id' , auth()->user()->agent_id);
        }else{
            return $q;
        }
    }

    public function attachments(){
        return $this->morphMany(Attachments::class, 'attachable');
    }
}