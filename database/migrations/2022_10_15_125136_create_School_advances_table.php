<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolAdvancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_advances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('advances_value');
            $table->integer('year');
            $table->integer('month_number');
            $table->string('status')->default(1);
            $table->unsignedBigInteger('teachers_id');
            $table->softDeletes();
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('school_types')->onDelete('cascade');
            $table->unsignedBigInteger('Transaction_id')->nullable();
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
        Schema::dropIfExists('school_advances');
    }
}
