<?php

use App\Models\AvailableIn;
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
        Schema::create('available_in', function (Blueprint $table) {
            $table->year("year_started");
            $table->char("program_code", 6);
            $table->tinyInteger("sem_no", false, true);
            $table->bigInteger("offering_id", false, true);
            $table->foreign('offering_id')->references('offering_id')->on('course_offerings')->onDelete('cascade');
            $table->foreign(['year_started', 'program_code', 'sem_no'])->references(['year_started', 'program_code', 'sem_no'])->on('semesters')->onDelete('cascade');
            $table->primary(['year_started', 'program_code', 'sem_no', 'offering_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('available_in');
    }
};
