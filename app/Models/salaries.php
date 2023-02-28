<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;

use App\Traits\HasStatus;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;


class salaries extends Model
{ use SoftDeletes;
    use HasStatus;
    protected $guarded = [];


   public function employee()
   {
   return $this->belongsTo('App\Models\employee','employee_id');
   }
   public function getActive(){
    return   $this -> status == 1 ? 'تم تسليم'  : ' لم يتم التسليم';
  }

  public function getSaleStatusWithSpan($status, $status_filed){
    if(!$this->{$this->{$status}}) return "<span class='badge badge-light-warning'> " .  __('translation.in' . $status_filed)  . " </span>";
    else  return "<span class='badge badge-light-success'> " .  __('translation.' . $status_filed)  . "</span>";
}



}
