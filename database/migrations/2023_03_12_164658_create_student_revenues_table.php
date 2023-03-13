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
        Schema::create('student_revenues', function (Blueprint $table) {
            $table->id();
            $table->string('student_name');
            $table->string('student_guard')->nullable();
            $table->decimal('amount', 12, 3);
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->unsignedBigInteger('opration_id')->nullable();
            $table->enum('revenue_type', ['student_renvue', 'transfer_renvue']);
            $table->enum('opration_type', ['bank', 'cash', 'shek']);
            $table->unsignedBigInteger('school_id')->nullable();
            $table->date('recept_date')->nullable();
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
        Schema::dropIfExists('student_revenues');
    }
};