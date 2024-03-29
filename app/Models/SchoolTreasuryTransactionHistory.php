<?php

namespace App\Models;

use App\Mail\EditTransaactionMail;
use App\Mail\withDrowalFromTuresy;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class SchoolTreasuryTransactionHistory extends Model
{
    use HasFactory;
    public $fillable = ['amount', 'type', 'school_id', 'note', 'financial_treasury_history',  'transaction_type', 'ref_id'];
    public const  TYPES =  [
        'advance' => "debit",
        'salries' => "debit",
        'spending' => "debit",
        "incentives" => "debit",
        'student_revenues' => "credit",
        'transfer_revenues'  => "credit",
        'main_treasury' => "credit"
    ];

    public function genrateUrl()
    {
        $urls = [

             'advance' => route('School.Advances.index', ['id' => $this->ref_id]),

            'salries' => route('School.salaries.index', ['id' => $this->ref_id]),
            'spending' => route('School.spending.index', ['id' => $this->ref_id]),
            'incentives' => route('School.Teachers_allowances.index', ['id' => $this->ref_id]),
            'student_revenues' => route('school.students.revenues.index', ['type' => 'student_revenues']),
            'transfer_revenues'  => route('school.students.revenues.index',  ['type' => 'transfer_revenues']),
            'main_treasury' => '',
        ];
        return $urls[$this->transaction_type];
    }
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
    public static function MakeTransacaion($amount, $transaction_type, $note, $school_id = 1, $ref = 1)
    {
        $Treasury = SchoolTreasury::getInstance();
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
            'school_id' => $school_id,
        ]);
        // Check IF Debit Or credit Trnsaction
        if ($type == 'credit')
            SchoolTreasury::IncreamntToTreasury($amount);
        else
            SchoolTreasury::DecreamtnFromTreasury($amount);

        try {
            $mail = setting('email') ?? 'jksa.work.1@gmail.com';
            Mail::to($mail)->send(new withDrowalFromTuresy($amount, $type, $instance->id));
        } catch (\Throwable $th) {
            session()->flash('error', __('translation.Some Thing Went Worng When We Send Email'));
            return $instance;
        }
        return $instance;
    }

    public function AppendTransactionToSupplier($transaction_id, $supplier_id)
    {
        $oldInstance = SchoolTreasuryTransactionHistory::findOrFail($transaction_id);
        $oldInstance->supplier_id = $supplier_id;
        $oldInstance->save();
    }

    public static function EditTransaction($transaction_id, $new_amount)
    {
        $oldInstance = SchoolTreasuryTransactionHistory::findOrFail($transaction_id);
        $old_amount  = $oldInstance->amount;
        $oldInstance->amount = $new_amount;
        $oldInstance->save();
        // dd($old_amount, $new_amount);
        if ($oldInstance->type == 'credit') {
            SchoolTreasury::creditTransactionEdit($old_amount, $new_amount);
            //  Heelo Jksa Altigani Osamn
        }

        if ($oldInstance->type == 'debit') {
            SchoolTreasury::debitTransactionEdit($old_amount, $new_amount);
        }

        try {
            $mail = setting('email') ?? 'jksa.work.1@gmail.com';
            Mail::to($mail)->send(new EditTransaactionMail($oldInstance->amount, $new_amount, $oldInstance->type, $oldInstance->id));
        } catch (\Throwable $th) {
            throw new Exception("Some Thing Went Worng When We Send Email", 51);
        }
    }

    public  static function DestoryTransaction($transaction_id)
    {
        $oldInstance = SchoolTreasuryTransactionHistory::findOrFail($transaction_id);
        if ($oldInstance->type == 'credit') {
            SchoolTreasury::DestoryCreditTransaction($oldInstance->amount);
        }
        if ($oldInstance->type == 'debit') {
            SchoolTreasury::DestoryDebitTransaction($oldInstance->amount);
        }
        $oldInstance->delete();
    }

    public function scopewhenType($query)
    {
        $query->when(request()->has('type') && request()->type != null, function ($q) {
            return $q->where('type', request()->type);
        });
    }
    public function scopeWhenSchoolType($query)
    {
        $query->when(request()->has('school_id') && request()->school_id != null, function ($q) {
            return $q->where('school_id', request()->school_id);
        });
    }

    public function School()
    {
        return  $this->belongsTo('App\Models\school_types', 'school_id');
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
