<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('teaches', function (Blueprint $table) {
            $table->bigInteger('offering_id');
            $table->bigInteger('prof_id');
            $table->foreign('offering_id')->references('offering_id')->on('course_offerings')->onDelete('cascade');
            $table->foreign('prof_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->primary(['offering_id', 'prof_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teaches');
    }
};
