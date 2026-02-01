<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->enum('grade', [7, 8, 9])->after('id');
            $table->unsignedTinyInteger('capacity')->after('name');

            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropUnique(['name']);
            $table->dropColumn(['level', 'capacity']);
        });
    }
};
