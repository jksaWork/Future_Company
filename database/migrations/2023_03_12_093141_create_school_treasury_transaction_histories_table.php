<?php

use App\Models\SchoolTreasuryTransactionHistory;
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
        Schema::create('school_treasury_transaction_histories', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['debit', 'credit'])->nullable();
            $table->enum('transaction_type', array_keys(SchoolTreasuryTransactionHistory::TYPES))->nullable();
            $table->decimal('amount', 30, 8);
            $table->unsignedBigInteger('ref_id');
            $table->unsignedBigInteger('school_id')->nullable();
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
        Schema::dropIfExists('school_treasury_transaction_histories');
    }
};