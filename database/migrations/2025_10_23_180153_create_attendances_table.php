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
Schema::create('attendances', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('session_id');
    $table->unsignedBigInteger('student_id');
    $table->string('status', 40)->comment('present,absent,excused');
    $table->string('attendance_type', 50)->comment('manual,facerec,norestrict,qr,location');
    $table->unsignedBigInteger('marked_by')->comment('teacher user id');
    $table->string('client_coordinates', 50)->nullable();
    $table->unsignedBigInteger('face_embedding_id')->nullable();
    $table->string('client_device_info', 400);
    $table->string('client_network_info', 400);
    $table->dateTime('created_at');
    $table->dateTime('updated_at');

    $table->unique(['session_id', 'student_id']);
    $table->index(['id', 'session_id', 'student_id', 'status']);

    $table->foreign('marked_by')->references('id')->on('users')->onUpdate('cascade');
    $table->foreign('session_id')->references('id')->on('course_sessions')->onDelete('cascade')->onUpdate('cascade');
    $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
