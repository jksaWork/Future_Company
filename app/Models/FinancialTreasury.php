<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTreasury extends Model
{
    use HasFactory;
    public $fillable = ['total' , 'total_debit' , 'total_credit'];

    public static function   getInstance(){
        return FinancialTreasury::first();
    }
    public static function IncreamtnFromTreasury($amount)
    :FinancialTreasury
    {
        $treasury = self::getInstance();
        $treasury->total += $amount;
        $treasury->total_credit += $amount;
        $treasury->save();
        return $treasury;
    }
    public static function DecreamtnFromTreasury($amount):FinancialTreasury
    {
        $treasury = self::getInstance();
        $treasury->total -= $amount;
        $treasury->total_debit += $amount;
        $treasury->save();
        return $treasury;
    }
}