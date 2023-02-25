<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialTreasuryTransactionHistorys extends Model
{
    use HasFactory;
    public const  TYPES =  ['advance', 'salries', 'spending', "incentives" , 'revenues' , 'installment' , 'main_treasury'];

}