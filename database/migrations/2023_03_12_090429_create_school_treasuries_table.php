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
        Schema::create('school_treasuries', function (Blueprint $table) {
            $table->id();
            $table->decimal('total', 30, 8)->nullable();
            $table->decimal('total_debit', 30, 8)->nullable();
            $table->decimal('total_credit', 30, 8)->nullable();

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
        Schema::dropIfExists('school_treasuries');
    }
};