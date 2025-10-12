<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_start_time_to_tests_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartTimeToTestsTable extends Migration
{
    public function up()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->timestamp('start_time')->nullable()->after('scheduled_at');
        });
    }

    public function down()
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn('start_time');
        });
    }
}
