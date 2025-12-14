<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    DB::statement("ALTER TABLE grades MODIFY status ENUM('submitted','approved','locked','revision_requested') NOT NULL");
}

public function down()
{
    DB::statement("ALTER TABLE grades MODIFY status ENUM('submitted','approved','locked') NOT NULL");
}

};
