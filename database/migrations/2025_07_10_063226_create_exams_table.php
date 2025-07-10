<?php

use App\Models\Course;
use App\Models\Exam;
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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Course::class)->constrained()->cascadeOnDelete();

            $table->string('title');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->unsignedInteger('duration'); //in_minutes
            $table->enum('status', Exam::$status);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
