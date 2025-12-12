<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('audit_logs', function (Blueprint $table) {
        $table->id();
        $table->string('action'); // created, updated, deleted
        $table->unsignedBigInteger('user_id')->nullable();
        $table->unsignedBigInteger('grade_id')->nullable();
        $table->unsignedBigInteger('student_id')->nullable();
        $table->unsignedBigInteger('subject_id')->nullable();
        $table->string('term')->nullable();
        $table->longText('old_values')->nullable();
        $table->longText('new_values')->nullable();
        $table->timestamps();
    });
}


    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
