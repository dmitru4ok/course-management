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
        Schema::create('course_blueprints', function (Blueprint $table) {
            $table->integer('course_code', true, true);
            $table->primary('course_code');
            $table->string('course_name', 100);
            $table->tinyInteger('credit_weight', false, true);
            $table->boolean('is_valid');
            $table->string('syllabus_pdf')->nullable();
            $table->char('faculty_code', 3);
            $table->foreign('faculty_code')->references('faculty_code')->on('faculties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_blueprints');
    }
};
