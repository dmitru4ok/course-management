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
        Schema::create('semesters', function (Blueprint $table) {
            $table->year("year_started");
            $table->char("program_code", 6);
            $table->tinyInteger("sem_no", false, true);
            $table->primary(['year_started', 'program_code', 'sem_no']);
            $table->foreign(['program_code', 'year_started'])->references(['program_code', 'year_started'])->on('study_program_instances')->onDelete('cascade');
            $table->boolean("is_valid")->default(false);
            $table->date("date_from");
            $table->date("date_to");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
