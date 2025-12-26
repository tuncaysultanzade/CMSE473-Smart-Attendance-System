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
        // Create the 'users' table

        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('self ID only for attendance internal system');
            $table->string('user_id', 40)->unique()->comment('string user id (teacher/student)');
            $table->string('email', 255)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('name', 255);
            $table->string('surname', 255);//->nullable();// nullable kaldir
            $table->string('password', 255)->comment('Hash');
            $table->string('user_role', 255)->comment('student, teacher, admin')->default('student');
            $table->unsignedBigInteger('user_department_id')->default(1);
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
            $table->string('qr_token')->unique()->nullable()->comment('Unique QR code token for attendance');

            $table->index(['id', 'user_id', 'email', 'user_department_id']);

            $table->foreign('user_department_id')->references('id')->on('departments')->onUpdate('cascade');
});


        // Create the 'password_reset_tokens' table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Create the 'sessions' table (if necessary)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the 'users' table
        Schema::dropIfExists('users');
        // Drop the 'password_reset_tokens' table
        Schema::dropIfExists('password_reset_tokens');
        // Drop the 'sessions' table
        Schema::dropIfExists('sessions');
    }
};
