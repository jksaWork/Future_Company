<?php

namespace Tests\Feature;

use App\Models\SchoolTreasury;
use App\Models\SchoolTreasuryTransactionHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SchollFinincalTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_increase_from_scholl_finanical_treasur()
    {
        SchoolTreasury::getInstance()->update(['total' => 0, 'total_debit' => 0, 'total_credit' => 0]);
        $AMOUNT = 4129123123;
        $oldData = SchoolTreasury::getInstance();
        $data = SchoolTreasury::IncreamntToTreasury($AMOUNT);
        // Asserions
        $this->assertEquals($data->total, $oldData->total + $AMOUNT);
        $this->assertEquals($data->total_credit, $oldData->total_credit +  $AMOUNT);
        $this->assertEquals($data->total_debit, $oldData->total_debit);
        // dd($data);
    }


    public function test_can_decrease_from_school_finanical_treasur()
    {
        SchoolTreasury::getInstance()->update(['total' => 0, 'total_debit' => 0, 'total_credit' => 0]);
        $AMOUNT = 4129123123;
        $oldData = SchoolTreasury::getInstance();
        $data = SchoolTreasury::DecreamtnFromTreasury($AMOUNT);
        // Asserions
        // $data = $data->fresh();
        $this->assertEquals($data->total, $oldData->total - $AMOUNT);
        $this->assertEquals($data->total_credit, $oldData->total_credit);
        $this->assertEquals($data->total_debit, $oldData->total_debit + $AMOUNT);
    }



    public function test_can_decrease_and_decrease_from_school_history_finanical_treasur()
    {
        SchoolTreasury::getInstance()->update(['total' => 0, 'total_debit' => 0, 'total_credit' => 0]);
        $AMOUNT = 4129123123;
        $oldData = SchoolTreasury::getInstance();
        $firsttance = SchoolTreasury::IncreamntToTreasury($AMOUNT);
        $secondtrans  = SchoolTreasury::DecreamtnFromTreasury($AMOUNT);
        // Asserions
        // dd($firsttance->toJson(), $thretance->toJson(), $secondtrans->toJson());
        // $oldData = $oldData->fresh();
        // dd($secondtrans->total_debit, $oldData->total_debit + $AMOUNT);
        $this->assertEquals($secondtrans->total, $oldData->total);
        $this->assertEquals($secondtrans->total_credit, $oldData->total_credit + $AMOUNT);
        $this->assertEquals($secondtrans->total_debit, $oldData->total_debit + $AMOUNT);
        // EditTransaction
    }

    public function test_can_i_make_transaction_and_edit_it_after_its_maked_in_shcoll_history()
    {

        // future_company
        // mbhtechc_future
        // mbhtechc_future

        $AMOUNT = rand(10000000, 10000000000);
        $New_AMOUNT = rand(10000000, 10000000000);
        $oldData = SchoolTreasury::getInstance();
        $oldData->update(['total' => 0, 'total_debit' => 0, 'total_credit' => 0]);
        // dd($oldData->fresh());
        //  Check IF I can Drowl And Payments
        $transaction = SchoolTreasuryTransactionHistory::MakeTransacaion($AMOUNT, 'main_treasury', 'hello');
        SchoolTreasuryTransactionHistory::EditTransaction($transaction->id, $New_AMOUNT);
        $oldData = SchoolTreasury::getInstance();
        $this->assertEquals($oldData->total, $New_AMOUNT);
    }
    public function test_can_i_make_credit_transaction_and_edit_it_after_its_maked()
    {

        // future_company
        // mbhtechc_future
        // mbhtechc_future
        $AMOUNT = rand(10000000, 10000000000);
        $New_AMOUNT = rand(10000000, 10000000000);
        $oldData = SchoolTreasury::getInstance();
        $oldData->update(['total' => 0, 'total_debit' => 0, 'total_credit' => 0]);
        //  Check IF I can Drowl And Payments
        $transaction = SchoolTreasuryTransactionHistory::MakeTransacaion($AMOUNT, 'student_revenues', 'hello');
        SchoolTreasuryTransactionHistory::EditTransaction($transaction->id, $New_AMOUNT);
        $oldData = $oldData->fresh();
        $this->assertEquals($oldData->total, $New_AMOUNT);
        $this->assertEquals($oldData->total_credit, $New_AMOUNT);

        SchoolTreasuryTransactionHistory::EditTransaction($transaction->id, $New_AMOUNT + 500);
        $oldData = $oldData->fresh();
        $this->assertEquals($oldData->total, $New_AMOUNT + 500);
        $this->assertEquals($oldData->total_credit, $New_AMOUNT + 500);


        //  Make Dbit Transacation
        $transaction = SchoolTreasuryTransactionHistory::MakeTransacaion($New_AMOUNT, 'spending', 'hello', 1);
        SchoolTreasuryTransactionHistory::EditTransaction($transaction->id, $New_AMOUNT);
        $oldData = SchoolTreasury::getInstance();
        $this->assertEquals($oldData->total, 500);
        $this->assertEquals($oldData->total_credit, $New_AMOUNT + 500);
        $this->assertEquals($oldData->total_debit, $New_AMOUNT);
    }


    public function test_add_and_edit_and_delelt_credit_transaction()
    {
        $AMOUNT = rand(10000000, 10000000000);
        $New_AMOUNT = rand(10000000, 10000000000);
        $oldData = SchoolTreasury::getInstance();
        $oldData->update(['total' => 0, 'total_debit' => 0, 'total_credit' => 0]);

        $transaction = SchoolTreasuryTransactionHistory::MakeTransacaion($AMOUNT, 'student_revenues', 'hello');
        SchoolTreasuryTransactionHistory::EditTransaction($transaction->id, $New_AMOUNT);
        $oldData = $oldData->fresh();
        $this->assertEquals($oldData->total, $New_AMOUNT);
        $this->assertEquals($oldData->total_credit, $New_AMOUNT);

        SchoolTreasuryTransactionHistory::DestoryTransaction($transaction->id);
        $oldData = $oldData->fresh();
        $this->assertEquals($oldData->total, 0);
        $this->assertEquals($oldData->total_credit, 0);
    }

    public function test_add_and_edit_and_delelt_debit_transaction()
    {
        $AMOUNT = 500;
        $New_AMOUNT = 400;
        $oldData = SchoolTreasury::getInstance();
        $oldData->update(['total' => 1000, 'total_debit' => 0, 'total_credit' => 0]);

        $transaction = SchoolTreasuryTransactionHistory::MakeTransacaion($AMOUNT, 'advance', 'hello');
        SchoolTreasuryTransactionHistory::EditTransaction($transaction->id, $New_AMOUNT);
        $oldData = $oldData->fresh();
        $this->assertEquals($oldData->total, (1000 - $New_AMOUNT));
        $this->assertEquals($oldData->total_debit, $New_AMOUNT);

        SchoolTreasuryTransactionHistory::DestoryTransaction($transaction->id);
        $oldData = $oldData->fresh();

        $this->assertEquals($oldData->total,  1000);
        $this->assertEquals($oldData->total_debit, 0);
    }

    public function test_fresh_data_base()
    {
        $oldData = SchoolTreasury::getInstance();
        $oldData->update(['total' => 0, 'total_debit' => 0, 'total_credit' => 0]);
        $this->assertTrue(true);
    }
}