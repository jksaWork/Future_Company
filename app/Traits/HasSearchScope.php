<?php
namespace App\Traits;

trait HasSearchScope {
    public  function scopeWhenSerach($q){
        return $q->when(request('search') , function ($q){
            return $q->where('name' ,'like' , '%' . request('search') . '%')
                ->orWhere('name' ,'like' , '%_' . request('search') . '_%')
                ->orWhere('name' ,'like' ,  request('search') )
            ;
        });
    }
}
