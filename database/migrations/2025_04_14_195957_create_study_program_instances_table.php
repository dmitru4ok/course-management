<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('study_program_instances', function (Blueprint $table) {
            $table->year('year_started');
            $table->char("program_code", 6);
            $table->primary(['year_started', 'program_code']);
            $table->string("program_name", 100);
            $table->char("program_type", 1);
           
            $table->char("faculty_code", 3);
            $table->foreign("faculty_code")->references("faculty_code")->on("faculties")->onDelete("cascade");
        });

        DB::statement("ALTER TABLE study_program_instances ADD CONSTRAINT chk_program_type CHECK (program_type IN ('B', 'M', 'D'))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('study_program_instances');
    }
};
