<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('School_teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->text('address');
            $table->bigInteger('salary');
            $table->date('month_number');
            $table->text('description')->nullable();
            $table->string('status')->default(1);
            $table->date('month');
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('school_types')->onDelete('cascade');
            $table->softDeletes();
            $table->unsignedBigInteger('categories_id');
            $table->foreign('categories_id')->references('id')->on('school_categories')->onDelete('cascade');
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
        Schema::dropIfExists('School_teachers');
    }
}
