<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const table_name = 'study_programs';
   
    public function up(): void
    {
        Schema::create(self::table_name, function (Blueprint $table) {
            $table->char("program_code", 6);
            $table->primary("program_code");
            $table->string("program_name", 100);
            $table->char("program_type", 1);
            $table->char("faculty_code", 3);
            $table->foreign("faculty_code")->references("faculty_code")->on("faculties")->onDelete("cascade");
            $table->boolean("is_valid")->default(true); // allow to instantiate only if accredited
        });

        Illuminate\Support\Facades\DB::statement( "ALTER TABLE " . self::table_name . " ADD CONSTRAINT chk_program_type CHECK (program_type IN ('B', 'M', 'D'))");
    }
    
    public function down(): void
    {
        Schema::dropIfExists(self::table_name);
    }
};
