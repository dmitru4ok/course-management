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
        Schema::create('course_offerings', function (Blueprint $table) {
            $table->id('offering_id');
            $table->primary('offering_id');
            $table->integer('classroom', false, true);
            $table->enum('building', array_column(\App\Enums\Building::cases(), 'value'));
            $table->integer('course_code', false, true)->nullable();
            $table->foreign('course_code')->references('course_code')->on('course_blueprints')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_offerings');
    }
};
