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
        Schema::create('financial_treasuries', function (Blueprint $table) {
            $table->id();
            $table->double('total', 15, 8)->nullable();
            $table->double('total_debit', 15, 8)->nullable();
            $table->double('total_credit', 15, 8)->nullable();
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
        Schema::dropIfExists('financial_treasuries');
    }
};