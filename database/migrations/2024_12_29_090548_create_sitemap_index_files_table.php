<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sitemap_index_files', function (Blueprint $table) {
            $table->mediumIncrements('id');

            $table->unsignedSmallInteger('sitemap_profile_id')->index();
            $table->string('file_name')->unique();
            $table->string('url');
            $table->timestamp('generated_at');

            $table->integer('url_count')->default(0);
            $table->boolean('is_current')->default(true);

            $table->timestamps();

            $table->foreign('sitemap_profile_id')->references('id')->on('sitemap_profiles')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sitemap_index_files');
    }
};
