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
Schema::create('courses', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('department_id');
    $table->string('course_code', 10)->unique();
    $table->string('course_name', 255);

    $table->foreign('department_id')->references('id')->on('departments')->onUpdate('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
