<?php

use App\Models\Exam;
use App\Models\Question;
use App\Models\Teacher;
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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Exam::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Teacher::class)->constrained()->cascadeOnDelete();

            $table->text('question');
            $table->enum('type', Question::$type); //Exam::$type before
            $table->unsignedInteger('weight')   ;
            $table->text('ref_answer');
            $table->json('ref_answer_embed'); //embedded teacher reference answer

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
