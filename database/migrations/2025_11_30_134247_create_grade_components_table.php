<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grade_components', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->string('name'); // quiz, project, exam
            $table->integer('weight'); // percentage of final grade
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_components');
    }
};
