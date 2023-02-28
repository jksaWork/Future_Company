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
        Schema::create('real_states', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('realstate_number');
            $table->string('address');
            $table->integer('price');
            $table->enum('type', ['rent', 'sale'])->defualt('rent');
            $table->text('description')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('is_rent')->default(0);
            $table->boolean('is_sale')->default(0);
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('real_state_categories');
            $table->foreign('owner_id')->references('id')->on('owners');
            $table->softDeletes();
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
        Schema::dropIfExists('real_states');
    }
};