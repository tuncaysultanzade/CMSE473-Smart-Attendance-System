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
Schema::create('course_sessions', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('course_group_id');
    $table->string('session_type', 50)->comment('theoretical, lab, tutorial');
    $table->date('session_date');
    $table->time('start_time');
    $table->time('end_time');
    $table->boolean('is_attendance_active')->default(false)->nullable()->comment('self attendance active');
    $table->integer('self_attendance_type')->nullable()->comment('NULL,norestrict,qr,location');
    $table->string('self_attendance_hash', 400)->nullable()->comment('Hash for QR');
    $table->string('teacher_computer_coordinates', 50)->nullable();
    $table->unsignedBigInteger('created_by');
    $table->dateTime('created_at');
    $table->dateTime('updated_at');

    $table->unique(['course_group_id', 'session_type', 'session_date', 'start_time', 'end_time']);

    $table->foreign('course_group_id')->references('id')->on('course_groups')->onDelete('cascade')->onUpdate('cascade');
    $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_sessions');
    }
};
