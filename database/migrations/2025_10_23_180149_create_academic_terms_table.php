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
Schema::create('academic_terms', function (Blueprint $table) {
    $table->id();
    $table->string('term', 50)->comment('Fall, Spring, Summer');
    $table->string('year', 20)->comment('Ex:2024/25');
    $table->date('term_start');
    $table->date('term_end');
    $table->boolean('is_active')->default(false);

    $table->unique(['term', 'year']);
    $table->index(['id', 'term', 'year']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_terms');
    }
};
