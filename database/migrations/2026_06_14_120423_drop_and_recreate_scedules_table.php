<?php

use App\Models\Period;
use App\Models\Teaching;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('schedules');

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Teaching::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Period::class)->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['teaching_id', 'period_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
