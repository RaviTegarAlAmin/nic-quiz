<?php

use App\Models\Exam;
use App\Models\ExamAssignment;
use App\Models\Student;
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
        Schema::create('exam_takers', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(ExamAssignment::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Student::class)->constrained()->cascadeOnDelete();

            $table->dateTime('start_at');
            $table->dateTime('finished_at')->nullable();
            $table->unsignedInteger('duration_used')->nullable();
            $table->enum('status', ['ongoing', 'on_hold', 'finished', 'expired']);
            $table->dateTime('last_active_at')->nullable();
            $table->ipAddress('ip_address')->nullable();

            $table->timestamps();

            $table->unique(['exam_assignment_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_takers');
    }
};
