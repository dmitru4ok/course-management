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
        Schema::create('course_registrations', function (Blueprint $table) {
            $table->bigInteger('offering_id');
            $table->tinyInteger('sem_no', false, true);
            $table->year('year_started');
            $table->string('program_code', 6);
            $table->timestamp('reg_date');
            $table->boolean('is_compulsory')->default(false);

            $table->primary(['offering_id', 'sem_no', 'year_started', 'program_code']);
            $table->foreign('offering_id')->references('offering_id')->on('course_offerings')->onDelete('cascade');
            $table->foreign(['sem_no', 'year_started', 'program_code'])->references(['sem_no', 'year_started', 'program_code'])->on('semesters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_registrations');
    }
};
