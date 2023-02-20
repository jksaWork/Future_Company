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
        Schema::create('realstate_installment', function (Blueprint $table) {
            $table->id();
            $table->integer('precentage')->default(0);
            $table->double('amount', 8 , 2)->default(0);
            $table->boolean('is_payed')->default(0);
            $table->timestamp('date')->nullable();
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->foreignId('realstate_id') -> references('id') -> on('real_states');
            $table->foreign('owner_id') -> references('id') -> on('owners');
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
        Schema::dropIfExists('table_realstate_installment');
    }
};
