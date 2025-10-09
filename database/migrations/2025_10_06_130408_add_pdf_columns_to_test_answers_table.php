<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('test_answers', function (Blueprint $table) {
            // Make question_id nullable for PDF submissions
            $table->foreignId('question_id')->nullable()->change();

            // Add PDF submission columns
            $table->string('answer_pdf_path')->nullable();
            $table->string('answer_pdf_original_name')->nullable();
            $table->timestamp('submitted_at')->nullable();

            // Add other useful columns
            $table->text('comments')->nullable();
            $table->integer('marks')->nullable();
        });
    }

    public function down()
    {
        Schema::table('test_answers', function (Blueprint $table) {
            $table->foreignId('question_id')->nullable(false)->change();
            $table->dropColumn([
                'answer_pdf_path',
                'answer_pdf_original_name',
                'submitted_at',
                'comments',
                'marks'
            ]);
        });
    }
};
