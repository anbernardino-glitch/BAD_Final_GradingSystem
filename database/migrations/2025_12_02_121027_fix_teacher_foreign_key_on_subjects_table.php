<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('subjects', function (Blueprint $table) {
        // Drop the old foreign key
        $table->dropForeign('fk_teacher'); // adjust with actual foreign key name
        $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('subjects', function (Blueprint $table) {
        $table->dropForeign(['teacher_id']);
        $table->foreign('teacher_id')->references('id')->on('users')->onDelete('set null');
    });
}

};
