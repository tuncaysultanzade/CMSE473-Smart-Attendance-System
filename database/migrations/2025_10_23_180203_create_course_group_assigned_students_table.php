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
Schema::create('course_group_assigned_students', function (Blueprint $table) {
    $table->unsignedBigInteger('course_group_id');
    $table->unsignedBigInteger('user_id');

    $table->primary(['course_group_id', 'user_id']);

    $table->foreign('course_group_id')->references('id')->on('course_groups')->onDelete('cascade')->onUpdate('cascade');
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_group_assigned_students');
    }
};
