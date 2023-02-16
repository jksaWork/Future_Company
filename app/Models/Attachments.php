<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function attachable(){
        return $this->morphTo();
    }

    public function getUrlAttribute($key)
    {
        switch($this->attachable_type){
            case 'App\Models\Owner':
                return  asset('owner/attachments/' . $key);
        }
        if($this->attachable_type =='App\Models\Offer') return asset('offers/attachments/' . $key);
        else return asset('agents/attachments/' . $key);
    }
}