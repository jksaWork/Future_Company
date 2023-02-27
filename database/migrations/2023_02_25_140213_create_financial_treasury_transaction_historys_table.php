<?php

use App\Models\FinancialTreasuryTransactionHistorys;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_treasury_transaction_historys', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['debit', 'credit'])->nullable();
            $table->enum('transaction_type', array_keys(FinancialTreasuryTransactionHistorys::TYPES))->nullable();
            $table->decimal('amount', 30, 8);
            $table->unsignedBigInteger('ref_id');
            $table->json('financial_treasury_history')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('financial_treasury_transaction_historys');
    }
};