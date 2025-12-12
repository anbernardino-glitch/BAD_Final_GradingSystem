<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('student_subject', function (Blueprint $table) {
        $table->string('grade')->nullable()->after('subject_id'); // can be string or decimal
    });
}

public function down()
{
    Schema::table('student_subject', function (Blueprint $table) {
        $table->dropColumn('grade');
    });
}

};
