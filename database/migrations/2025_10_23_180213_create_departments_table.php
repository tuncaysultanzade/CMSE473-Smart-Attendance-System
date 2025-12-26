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
Schema::create('departments', function (Blueprint $table) {
    $table->id();
    $table->string('department_code', 10)->unique();
    $table->string('department_name', 255);
    $table->string('department_coordinates', 255);
    $table->integer('department_radius_in_meters')->default(100)->comment('for location based attendances');
    $table->timestamps();
});

    DB::table('departments')->insert([
        'department_code' => 'DPT01',
        'department_name' => 'Test Department',
        'department_coordinates' => '123123123',
        'department_radius_in_meters' => 100,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
//production da kaldir
        DB::table('users')->insert([
        'user_id' => 'U11111',
        'email' => 'deneme@example.com',
        'name' => 'deneme',
        'surname' => 'kullanici',
        'password' => Hash::make('12345678'),
        'user_role' => 'student',
        'user_department_id' => 1,
    ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
