<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_allowances', function (Blueprint $table) {
            $table->id();
            $table->integer('month_number')->default(0);
            $table->string('status')->default(0);
            $table->unsignedBigInteger('allowances_id');
            $table->unsignedBigInteger('employee_id');
            $table->foreign('allowances_id')->references('id')->on('allowances')->onDelete('cascade');
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
        Schema::dropIfExists('employee_allowances');
    }
}
