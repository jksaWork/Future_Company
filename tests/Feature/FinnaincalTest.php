<?php

namespace Tests\Feature;

use App\Models\FinancialTreasury;
use App\Models\FinancialTreasuryTransactionHistorys;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FinnaincalTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_increase_from_finanical_treasur()
    {
        FinancialTreasury::getInstance()->update(['total' => 0, 'total_debit' => 0, 'total_credit' => 0]);
        $AMOUNT = 4129123123;
        $oldData = FinancialTreasury::getInstance();
        $data = FinancialTreasury::IncreamntToTreasury($AMOUNT);
        // Asserions
        $this->assertEquals($data->total, $oldData->total + $AMOUNT);
        $this->assertEquals($data->total_credit, $oldData->total_credit +  $AMOUNT);
        $this->assertEquals($data->total_debit, $oldData->total_debit);
    }
    public function test_can_decrease_from_finanical_treasur()
    {
        FinancialTreasury::getInstance()->update(['total' => 0, 'total_debit' => 0, 'total_credit' => 0]);
        $AMOUNT = 4129123123;
        $oldData = FinancialTreasury::getInstance();
        $data = FinancialTreasury::DecreamtnFromTreasury($AMOUNT);
        // Asserions
        // $data = $data->fresh();
        $this->assertEquals($data->total, $oldData->total - $AMOUNT);
        $this->assertEquals($data->total_credit, $oldData->total_credit);
        $this->assertEquals($data->total_debit, $oldData->total_debit + $AMOUNT);
    }


    public function test_can_decrease_and_decrease_from_finanical_treasur()
    {
        FinancialTreasury::getInstance()->update(['total' => 0, 'total_debit' => 0, 'total_credit' => 0]);
        $AMOUNT = 4129123123;
        $oldData = FinancialTreasury::getInstance();
        $firsttance = FinancialTreasury::IncreamntToTreasury($AMOUNT);
        $secondtrans  = FinancialTreasury::DecreamtnFromTreasury($AMOUNT);
        // Asserions
        // dd($firsttance->toJson(), $thretance->toJson(), $secondtrans->toJson());
        // $oldData = $oldData->fresh();
        // dd($secondtrans->total_debit, $oldData->total_debit + $AMOUNT);
        $this->assertEquals($secondtrans->total, $oldData->total);
        $this->assertEquals($secondtrans->total_credit, $oldData->total_credit + $AMOUNT);
        $this->assertEquals($secondtrans->total_debit, $oldData->total_debit + $AMOUNT);
        // dd($secondtrans->total_debit, );
        // EditTransaction

    }



    public function test_can_i_make_transaction_and_edit_it_after_its_maked()
    {

        // future_company
        // mbhtechc_future
        // mbhtechc_future
        $AMOUNT = rand(10000000, 10000000000);
        $New_AMOUNT = rand(10000000, 10000000000);
        $oldData = FinancialTreasury::getInstance();
        $oldData->update(['total' => 0, 'total_debit' => 0, 'total_credit' => 0]);
        //  Check IF I can Drowl And Payments
        $transaction = FinancialTreasuryTransactionHistorys::MakeTransacaion($AMOUNT, 'main_treasury', 'hello');
        FinancialTreasuryTransactionHistorys::EditTransaction($transaction->id, $New_AMOUNT);
        $oldData = FinancialTreasury::getInstance();
        $this->assertEquals($oldData->total, $AMOUNT);
    }

    public function test_fresh_data_base()
    {
        $oldData = FinancialTreasury::getInstance();
        $oldData->update(['total' => 0, 'total_debit' => 0, 'total_credit' => 0]);
        $this->assertTrue(true);
    }
}