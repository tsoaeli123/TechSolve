<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            // Add marks column if it doesn't exist
            if (!Schema::hasColumn('submissions', 'marks')) {
                $table->integer('marks')->nullable();
            }

            // Add comments column if it doesn't exist
            if (!Schema::hasColumn('submissions', 'comments')) {
                $table->text('comments')->nullable();
            }

            // Add marked_file_path column at the end
            if (!Schema::hasColumn('submissions', 'marked_file_path')) {
                $table->string('marked_file_path')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table) {
            if (Schema::hasColumn('submissions', 'marks')) {
                $table->dropColumn('marks');
            }
            if (Schema::hasColumn('submissions', 'comments')) {
                $table->dropColumn('comments');
            }
            if (Schema::hasColumn('submissions', 'marked_file_path')) {
                $table->dropColumn('marked_file_path');
            }
        });
    }
};
