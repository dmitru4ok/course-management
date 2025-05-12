<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('semester_course_requirements', function (Blueprint $table) {
            $table->year("year_started");
            $table->char("program_code", 6);
            $table->tinyInteger("sem_no", false, true);
            $table->integer("course_code", false, true);
            $table->foreign('course_code')->references('course_code')->on('course_blueprints')->onDelete('cascade');
            $table->foreign(['year_started', 'program_code', 'sem_no'])->references(['year_started', 'program_code', 'sem_no'])->on('semesters')->onDelete('cascade');
            $table->primary(['year_started', 'program_code', 'sem_no', 'course_code']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semester_course_requirements');
    }
};
