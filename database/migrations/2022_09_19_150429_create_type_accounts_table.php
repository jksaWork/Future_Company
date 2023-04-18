<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_accounts', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->integer('value');
            $table->string('status')->default(1);
            $table->unsignedBigInteger('Transaction_id')->nullable();
            $table->date('month');
            $table->unsignedBigInteger('school_spendings_id');
            $table->foreign('school_spendings_id')->references('id')->on('school_spendings')->onDelete('cascade');
           
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
        Schema::dropIfExists('type_accounts');
    }
}
