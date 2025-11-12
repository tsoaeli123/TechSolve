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
    Schema::table('materials', function (Blueprint $table) {
        $table->enum('material_type', ['file', 'video', 'link'])->default('file');
        $table->string('video_path')->nullable();
        $table->string('video_original_name')->nullable();
        $table->text('video_embed_code')->nullable();
        $table->string('resource_link')->nullable();

        // Optional: Rename existing fields for consistency
        // $table->renameColumn('file_path', 'file_path'); // if already exists
        // $table->renameColumn('original_name', 'file_original_name'); // if needed
    });
}

public function down()
{
    Schema::table('materials', function (Blueprint $table) {
        $table->dropColumn(['material_type', 'video_path', 'video_original_name', 'video_embed_code', 'resource_link']);
    });
}
};
