<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolTeachersAllowancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_teachers_allowances', function (Blueprint $table) {
            $table->id();
            $table->integer('month_number');
            $table->integer('year');
            $table->string('status')->default(1);
            $table->unsignedBigInteger('allowances_id');
            $table->unsignedBigInteger('Transaction_id')->nullable();
            $table->unsignedBigInteger('teachers_id');
            $table->softDeletes();
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('school_types')->onDelete('cascade');
            $table->foreign('allowances_id')->references('id')->on('school_allowances')->onDelete('cascade');
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
        Schema::dropIfExists('school_teachers_allowances');
    }
}
