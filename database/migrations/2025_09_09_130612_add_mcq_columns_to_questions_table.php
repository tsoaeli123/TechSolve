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
    Schema::table('questions', function (Blueprint $table) {
        $table->json('options')->nullable(); // store MCQ options
        $table->integer('correct_answer')->nullable(); // store correct option index
    });
}

public function down()
{
    Schema::table('questions', function (Blueprint $table) {
        $table->dropColumn(['options', 'correct_answer']);
    });
}

};
