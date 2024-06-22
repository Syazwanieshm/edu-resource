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
    Schema::create('class_subject', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('class_id');
        $table->unsignedBigInteger('sub_id');
        // Add any additional fields you need
        //$table->timestamps();
        
        $table->foreign('class_id')->references('id')->on('class')->onDelete('cascade');
        $table->foreign('sub_id')->references('id')->on('subject')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_subject');
    }
};
