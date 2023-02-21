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
        Schema::create('owners_realstates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('realstate_id') -> references('id') -> on('real_states');
            $table->foreignId('owner_id') -> references('id') -> on('owners');
            $table->enum('type' , ['rent' , 'sale'])->nullable();
            $table->integer('month_count')->default(0);
            $table->boolean('rent_status')->default(1);
            $table->boolean('sale_status')->default(1);
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
        Schema::drop('owners_realstates');
    }
};