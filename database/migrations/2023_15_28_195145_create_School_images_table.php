<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('filename');
            $table->unsignedBigInteger('imageable_id');
            $table->string('imageable_type');
            
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('school_types')->onDelete('cascade');
            // $table->foreign('imageable_id')->references('id')->on('employees')->onDelete('cascade');
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
        Schema::dropIfExists('school_images');
    }
}
