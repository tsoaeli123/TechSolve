<?php
// database/migrations/2024_01_01_000000_add_marking_columns_to_test_answers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMarkingColumnsToTestAnswersTable extends Migration
{
    public function up()
    {
        Schema::table('test_answers', function (Blueprint $table) {
            $table->string('marked_pdf_path')->nullable()->after('answer_pdf_original_name');
            $table->string('marked_pdf_original_name')->nullable()->after('marked_pdf_path');
            $table->timestamp('marked_at')->nullable()->after('marked_pdf_original_name');
            $table->unsignedBigInteger('marked_by')->nullable()->after('marked_at');
            $table->enum('marking_status', ['pending', 'in_progress', 'completed'])->default('pending')->after('marked_by');

            // Foreign key constraint
            $table->foreign('marked_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('test_answers', function (Blueprint $table) {
            $table->dropForeign(['marked_by']);
            $table->dropColumn([
                'marked_pdf_path',
                'marked_pdf_original_name',
                'marked_at',
                'marked_by',
                'marking_status'
            ]);
        });
    }
}
