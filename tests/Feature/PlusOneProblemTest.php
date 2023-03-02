<?php

namespace Tests\Feature;

use App\Models\FinancialTreasury;
use App\Models\FinancialTreasuryTransactionHistorys;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlusOneProblemTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_i_fex_plus_one_problem()
    {
        $response = $this->get('/');
        $oldData = FinancialTreasury::getInstance();
        $oldData->update(['total' => 0, 'total_debit' => 0, 'total_credit' => 0]);
        $AMOUNT = 99999999999988888;
        // dd($AMOUNT);
        $New_AMOUNT = 99999999999999;
        $transaction = FinancialTreasuryTransactionHistorys::MakeTransacaion($AMOUNT, 'installment', 'hello');
        $oldData = $oldData->fresh();
        $this->assertEquals($oldData->total, $New_AMOUNT);
        $this->assertEquals($oldData->total_credit, $New_AMOUNT);
    }
}
