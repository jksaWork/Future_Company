<?php

namespace Tests\Feature;

use App\Models\FinancialTreasury;
use App\Models\FinancialTreasuryTransactionHistorys;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionHistoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_i_make_can_not_able_to_make_transaction_with_less_total(){
        try {
            $instance = FinancialTreasury::getInstance();
            if($instance->total > 0 ) return $this->assertTrue(true);
            $res = FinancialTreasuryTransactionHistorys::MakeTransacaion(1000,'advance',1);
        } catch (\Throwable $th) {
            $this->assertTrue($th->getCode() == 50);
        }
    }

    public function test_can_i_pay_to_financial_treasury()
    {
        $instance = FinancialTreasury::getInstance();
        $res = FinancialTreasuryTransactionHistorys::MakeTransacaion(1000,'installment',1);
        $this->assertEquals($res->total ,$instance->total + 1000);
        $this->assertEquals($res->total_credit ,$instance->total_credit + 1000);
        $this->assertEquals($res->total_debit ,$instance-> total_debit);
    }

    public function test_can_i_dorwal_fom_financial_treasury()
    {
        $instance = FinancialTreasury::getInstance();
        $res = FinancialTreasuryTransactionHistorys::MakeTransacaion(1000,'advance',1);
        $this->assertEquals($res->total ,$instance->total - 1000);
        $this->assertEquals($res->total_credit ,$instance->total_credit);
        $this->assertEquals($res->total_debit ,$instance->total_debit + 1000);
    }

    public function test_affter_this_transaction_its_ok_or_note(){
        $instance = FinancialTreasury::getInstance();
        $this->assertEquals($instance->total ,  $instance->total_credit -$instance->total_debit);
    }

}
