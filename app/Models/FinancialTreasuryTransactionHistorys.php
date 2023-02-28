<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTreasuryTransactionHistorys extends Model
{
    use HasFactory;
    public $fillable = ['amount', 'type', 'note', 'financial_treasury_history',  'transaction_type', 'ref_id'];
    public const  TYPES =  [
        'advance' => "debit",
        'salries' => "debit",
        'spending' => "debit",
        "incentives" => "debit",
        'revenues' => "credit",
        'installment'  => "credit",
        'D' => "credit"
    ];
    // this function to make new Record On  Transacation hisotry
    public const  STATUS = ['primary',  'secondary', 'success', 'info', 'warning', 'danger', 'dark'];
    public static function  getStatus()
    {
        return array_combine(array_keys(self::TYPES), self::STATUS);
    }

    public function getTransactionType()
    {
        return "<span class='badge badge-" .  self::getStatus()[$this->transaction_type] . "'>" . __('translation.' . $this->transaction_type)  . "</span>";
    }
    public static function MakeTransacaion($amount, $transaction_type, $note, $ref = 1)
    {
        $Treasury = FinancialTreasury::getInstance();
        $json = $Treasury->toJson();

        $type = self::TYPES[$transaction_type];
        // Insert to Json
        if ($type == 'debit') {
            if ($Treasury->total < $amount) {
                throw new Exception('The Treasury Is Less Than Amount', 50);
            }
        }
        $instance  = self::create([
            'amount' => $amount,
            'type' => $type,
            'financial_treasury_history' => $json,
            'transaction_type' => $transaction_type,
            'note' => $note,
            'ref_id' => $ref,
        ]);
        // Check IF Debit Or credit Trnsaction
        if ($type == 'credit')
            FinancialTreasury::IncreamntToTreasury($amount);
        else
            FinancialTreasury::DecreamtnFromTreasury($amount);
        return $instance;
    }

    public static function EditTransaction($transaction_id, $new_amount)
    {
        $oldInstance = FinancialTreasuryTransactionHistorys::findOrFail($transaction_id);
        $old_amount  = $oldInstance->amount;
        $oldInstance->amount = $new_amount;
        $oldInstance->save();
        // dd($old_amount, $new_amount);
        if ($oldInstance->type == 'credit') {
            FinancialTreasury::DecreamtnFromTreasury($old_amount);
            FinancialTreasury::IncreamntToTreasury($new_amount);
        }
        //  Heelo Jksa Altigani Osamn
        if ($oldInstance->type == 'debit') {
            FinancialTreasury::IncreamntToTreasury($old_amount);
            FinancialTreasury::DecreamtnFromTreasury($new_amount);
        }
    }

    public function scopewhenType($query)
    {
        $query->when(request()->has('type') && request()->type != null, function ($q) {
            return $q->where('type', request()->type);
        });
    }

    public function scopewhenTransactionType($query)
    {
        $query->when(request()->has('transaction_type') && request()->transaction_type != null, function ($q) {
            return $q->where('transaction_type', request()->transaction_type);
        });
    }

    public function scopeWhenFromDate($query)
    {
        $query->when(request()->has('from_date'), function ($q) {
            return $q->where('created_at', '>=',  request()->from_date);
        });
    }

    public function scopeWhenToDate($query)
    {
        $query->when(request()->has('to_date'), function ($q) {
            return $q->where('created_at', ',=',  request()->to_date);
        });
    }
}
