<?php

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
        Schema::create('installments_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('realstate_id')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->double('amount', 15, 8)->nullable();
            $table->integer('order_number')->nullable();
            $table->foreign('realstate_id')->references('id')->on('real_states');
            $table->foreign('owner_id')->references('id')->on('owners');
            $table->unsignedBigInteger('transaction_id')->nullable();
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
        Schema::dropIfExists('installments_history');
    }
};