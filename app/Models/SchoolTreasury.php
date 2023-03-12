<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolTreasury extends Model
{
    use HasFactory;
    public $fillable = ['total', 'total_debit', 'total_credit'];

    public static function  getInstance()
    {
        return SchoolTreasury::first();
    }
    public static function IncreamntToTreasury($amount): SchoolTreasury
    {
        $treasury = self::getInstance();
        $treasury->total = $treasury->total + $amount;
        $treasury->total_credit = $treasury->total_credit +  $amount;
        $treasury->save();
        return $treasury;
    }
    public static function DecreamtnFromTreasury($amount): SchoolTreasury
    {
        $treasury = self::getInstance();
        $treasury->total = $treasury->total -  $amount;
        $treasury->total_debit  = $treasury->total_debit + $amount;
        $treasury->save();
        return $treasury;
    }

    public static function IncToatalAndDecDebitTreasury($amount): SchoolTreasury
    {
        $treasury = self::getInstance();
        $treasury->total = $treasury->total +  $amount;
        $treasury->total_debit = $treasury->total_debit - $amount;
        $treasury->save();
        return $treasury;
    }



    public static function creditTransactionEdit($old_amount, $new_amount): SchoolTreasury
    {

        $treasury = self::getInstance();
        $treasury->total = $treasury->total - $old_amount + $new_amount;
        $treasury->total_credit = $treasury->total_credit - $old_amount + $new_amount;
        $treasury->save();
        return $treasury;
    }


    public static function debitTransactionEdit($old_amount, $new_amount): SchoolTreasury
    {
        $treasury = self::getInstance();
        $treasury->total = $treasury->total + $old_amount - $new_amount;
        $treasury->total_debit = $treasury->total_debit - $old_amount + $new_amount;
        $treasury->save();

        return $treasury;
    }

    public static function DestoryCreditTransaction($old_amount)
    {
        $treasury = self::getInstance();
        if ($treasury->total < $old_amount) throw new Exception('The Treasury Is Less Than Amount', 50);
        $treasury->total = $treasury->total - $old_amount;
        $treasury->total_credit = $treasury->total_credit - $old_amount;
        $treasury->save();
        return $treasury;
    }

    public static function DestoryDebitTransaction($old_amount)
    {
        $treasury = self::getInstance();
        // Remove THe Exception ON Debit Cuase This Is Credit
        // if ($treasury->total < $old_amount) throw new Exception('The Treasury Is Less Than Amount', 50);
        $treasury->total = $treasury->total + $old_amount;
        $treasury->total_debit = $treasury->total_debit - $old_amount;
        $treasury->save();
        return $treasury;
    }
}