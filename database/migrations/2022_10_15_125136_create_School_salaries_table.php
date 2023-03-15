<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_salaries', function (Blueprint $table) {
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
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('school_types')->onDelete('cascade');
            $table->unsignedBigInteger('Transaction_id')->nullable();
            $table->unsignedBigInteger('teachers_id');
            $table->foreign('teachers_id')->references('id')->on('School_teachers')->onDelete('cascade');
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
        Schema::dropIfExists('school_salaries');
    }
}
