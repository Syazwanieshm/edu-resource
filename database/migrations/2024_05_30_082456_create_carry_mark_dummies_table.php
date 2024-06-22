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
        Schema::create('carry_mark_dummies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('student_dummies')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subject_dummies')->onDelete('cascade');
            $table->float('carry_mark', 5, 2);
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
        Schema::dropIfExists('carry_mark_dummies');
    }
};
