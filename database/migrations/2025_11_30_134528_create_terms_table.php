<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 1st Semester 2025-2026
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });

        // Add term_id to grades if you want term-based grades
        Schema::table('grades', function (Blueprint $table) {
            $table->foreignId('term_id')->nullable()->constrained('terms')->after('subject_id');
        });
    }

    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropForeign(['term_id']);
            $table->dropColumn('term_id');
        });
        Schema::dropIfExists('terms');
    }
};
