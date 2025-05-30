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
        Schema::create('website_content_blocks', function (Blueprint $table) {
            $table->smallIncrements('id');

            $table->unsignedSmallInteger('content_id')->index();
            $table->unsignedSmallInteger('parent_id')->nullable()->index();

            $table->string('slug')->nullable();
            $table->string('type', 32);
            $table->string('mode', 16)->default('view');
            $table->string('view_path')->nullable();
            $table->string('component_class')->nullable();

            $table->boolean('is_enabled')->default(true);
            $table->boolean('enable_cache')->default(true);
            $table->unsignedSmallInteger('cache_ttl')->default(60);

            $table->json('settings')->nullable();
            $table->json('data')->nullable();
            $table->unsignedSmallInteger('order')->default(0);

            $table->timestamps();

            $table->foreign('content_id')->references('id')->on('website_contents')->cascadeOnDelete();
            $table->foreign('parent_id')->references('id')->on('website_content_blocks')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_content_blocks');
    }
};
