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
        $oldData = FinancialTreasury::getInstance();
        $data = FinancialTreasury::IncreamtnFromTreasury(1000);
        // Asserions
        $this->assertEquals($data->total ,$oldData->total + 1000);
        $this->assertEquals($data->total_credit ,$oldData->total_credit +  1000);
        $this->assertEquals($data->total_debit ,$oldData-> total_debit);
    }
    public function test_can_decrease_from_finanical_treasur()
    {
        $oldData = FinancialTreasury::getInstance();
        $data = FinancialTreasury::DecreamtnFromTreasury(1000);
        // Asserions
        $this->assertEquals($data->total ,$oldData->total - 1000);
        $this->assertEquals($data->total_credit ,$oldData->total_credit);
        $this->assertEquals($data->total_debit ,$oldData-> total_debit + 1000);
    }


    public function test_can_decrease_and_decrease_from_finanical_treasur()
    {
        $oldData = FinancialTreasury::getInstance();
        $data = FinancialTreasury::DecreamtnFromTreasury(1000);
        $data = FinancialTreasury::IncreamtnFromTreasury(1000);
        // Asserions
        $this->assertEquals($data->total ,$oldData->total);
        $this->assertEquals($data->total_credit ,$oldData->total_credit + 1000);
        $this->assertEquals($data->total_debit ,$oldData-> total_debit + 1000);
    }
}
