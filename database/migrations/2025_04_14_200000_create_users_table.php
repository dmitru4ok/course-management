<?php

use App\Enums\UserType;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->enum('role', array_column(UserType::cases(), 'value'));
            $table->string('name', 100);
            $table->string('surname', 100);
            $table->string('email')->unique();
            $table->string('password');
            $table->year('year_started')->nullable();
            $table->char('program_code', 6)->nullable();

            $table->foreign(['program_code', 'year_started'])->references(['program_code', 'year_started'])->on('study_program_instances')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
