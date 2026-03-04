<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('reference_number')->unique();
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['tuition', 'scholarship_credit', 'miscellaneous', 'refund']);
            $table->enum('method', ['cash', 'gcash', 'bank_transfer', 'scholarship']);
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed', 'reversed'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};