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
    public function Owner(){
        $this->belongsTo(Owner::class , 'owenr_id');
    }
    public function getSaleStatusWithSpan($status, $status_filed){
        if(!$this->{$this->{$status}}) return "<span class='badge badge-light-warning'> " .  __('translation.in' . $status_filed)  . " </span>";
        else  return "<span class='badge badge-light-success'> " .  __('translation.' . $status_filed)  . "</span>";
    }

}
