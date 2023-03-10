<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->Integer('advances');
            $table->integer('month_number');
            $table->integer('year');
            $table->text('discrption')->nullable();
            $table->bigInteger('totle_salaries');
            $table->Integer('discounts');
            $table->string('status')->default(1);
            $table->bigInteger('fixed_salary');
            $table->bigInteger('allowancess_fixed');
            $table->softDeletes();
            $table->unsignedBigInteger('Transaction_id')->nullable();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
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
        Schema::dropIfExists('salaries');
    }
}
