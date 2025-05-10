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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id');
            $table->char('role', 1);
            $table->string('name', 100);
            $table->string('surname', 100);
            $table->string('email')->unique();
            $table->string('password');
        });

        Illuminate\Support\Facades\DB::statement( "ALTER TABLE users ADD CONSTRAINT chk_role CHECK (role IN ('S', 'P', 'A'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
