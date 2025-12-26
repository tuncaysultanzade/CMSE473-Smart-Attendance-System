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
Schema::create('course_groups', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('course_id');
    $table->integer('group_number');
    $table->unsignedBigInteger('academic_term_id');

    $table->unique(['course_id', 'group_number', 'academic_term_id']);

    $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
    $table->foreign('academic_term_id')->references('id')->on('academic_terms')->onDelete('cascade')->onUpdate('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_groups');
    }
};
