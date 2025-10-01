<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add columns to tests table
        Schema::table('tests', function (Blueprint $table) {
            $table->boolean('has_pdf')->default(false);
            $table->string('pdf_path')->nullable();
            $table->string('pdf_original_name')->nullable();
        });

        // Add columns to questions table
        Schema::table('questions', function (Blueprint $table) {
            $table->boolean('is_pdf_question')->default(false);
            $table->boolean('contains_math')->default(false);
        });
    }

    public function down(): void
    {
        // Remove columns from tests table
        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn(['has_pdf', 'pdf_path', 'pdf_original_name']);
        });

        // Remove columns from questions table
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn(['is_pdf_question', 'contains_math']);
        });
    }
};
