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
        Schema::create('study_program_instances', function (Blueprint $table) {
            $table->year('year_started');
            $table->char("program_code", 6);
            $table->primary(['year_started', 'program_code']);
            $table->foreign("program_code")->references("program_code")->on("study_programs")->onDelete("cascade");
            $table->boolean("is_active")->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_program_instances');
    }
};
