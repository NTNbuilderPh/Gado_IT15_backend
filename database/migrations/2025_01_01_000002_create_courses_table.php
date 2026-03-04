<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_code')->unique();
            $table->string('course_name');
            $table->text('description')->nullable();
            $table->integer('units')->default(3);
            $table->string('schedule')->nullable();
            $table->string('instructor')->nullable();
            $table->string('room')->nullable();
            $table->integer('capacity')->default(40);
            $table->integer('students_count')->default(0);
            $table->enum('semester', ['1st Semester', '2nd Semester', 'Summer'])->default('1st Semester');
            $table->string('academic_year')->default('2024-2025');
            $table->enum('status', ['open', 'closed', 'cancelled'])->default('open');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};