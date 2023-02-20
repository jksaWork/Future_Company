<?php

namespace App\Models;

use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    use HasFactory, HasStatus;
    public $guarded = [];

    public function __construct()
    {
        $this->status_filed = 'ready';
    }
    /**
     * Get the user that owns the RealState
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Category()
    {
        return $this->belongsTo(RealStateCategory::class, 'category_id');
    }

    public function attachments(){
        return $this->morphMany(Attachments::class, 'attachable');
    }

    public function ChangeSaleStatus($is_sale){
        $this->{$is_sale} = ! $this->{$is_sale};
        $this->save();

    }
    public function Owners(){
       return  $this->belongsToMany(Owner::class , 'owners_realstates', 'realstate_id', 'owner_id')
       ->withPivot('month_count', 'rent_status');
    }

    public function getSaleStatusWithSpan($status, $status_filed){
        if(!$this->{$this->{$status}}) return "<span class='badge badge-light-warning'> " .  __('translation.in' . $status_filed)  . " </span>";
        else  return "<span class='badge badge-light-success'> " .  __('translation.' . $status_filed)  . "</span>";
    }


    public function Revenues(){
        return  $this->belongsToMany(Owner::class , 'rent_revenues', 'realstate_id', 'owner_id')
        ->withPivot('month_number', 'status', 'price')
        ->orderByPivot('created_at' , 'desc');
     }
     public function Installments(){
        return $this->hasMany(RealstateInstallment::class, 'realstate_id');
     }

    public function CurrentOwner(){
        return  $this->belongsToMany(Owner::class , 'owners_realstates', 'realstate_id', 'owner_id')
        ->withPivot('month_count', 'rent_status')
        ->wherePivot('rent_status' , 1)
        ->orderByPivot('created_at', 'desc');
    }

    //  Real State Scopes
    public function scopetypeScope($query){
        $query->when(request()->has('type') , function($q){
            return $q->where('type' , request()->type ?? 'rent');
        });
    }

    public function scopeStatusScope($query){
        $query->when(request()->has('status')  , function($q){
            return $q->where('status' , request()->status ?? '1');
        });
    }

    public function scoperentOrSaleScope($query){
        return $query->when(request()->has('is_rent') , function($q){
            return $q->where('is_rent' , request()->is_rent ?? '1');
        })->when(request()->has('is_sale') , function($q){
            return $q->where('is_sale' , request()->is_sale ?? '1');
        });

    }

}