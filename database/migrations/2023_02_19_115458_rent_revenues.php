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
        Schema::create('rent_revenues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('realstate_id')->references('id')->on('real_states');
            $table->foreignId('owner_id')->references('id')->on('owners');
            $table->integer('month_number')->default(0);
            $table->boolean('status')->default(0);
            $table->integer('price')->default(0);
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
        //
    }
};