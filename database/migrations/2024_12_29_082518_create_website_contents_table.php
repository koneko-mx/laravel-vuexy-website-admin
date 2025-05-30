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
        Schema::create('website_contents', function (Blueprint $table) {
            $table->smallIncrements('id');

            $table->unsignedSmallInteger('site_id')->index();
            $table->unsignedSmallInteger('seo_profile_id')->nullable()->index();

            // Metadata
            $table->string('title')->index();
            $table->string('slug')->unique();
            $table->string('description');
            $table->json('keywords')->nullable();

            // Template & Type content
            $table->string('template')->nullable();
            $table->string('template_variant')->nullable();
            $table->string('type', 16)->default('page')->index();   // Enum: Content, Landing, Product, Category Blog, Partial
            $table->string('render_mode', 16)->default('static');
            $table->string('block_mode', 16)->default('db');
            $table->string('source', 16)->default('db');
            $table->string('render_as')->nullable();

            //canonical url
            $table->string('canonical_url')->nullable();

            // Content
            $table->json('content_blocks')->nullable();             // Bloques estructurados
            $table->json('seo_overrides')->nullable();

            // Control
            $table->boolean('is_draft')->default(true)->index();
            $table->boolean('is_sensitive')->default(false)->index(); // Allow dangerous Blade content
            $table->boolean('is_partial')->default(false)->index();

            // Visibilidad
            $table->json('roles')->nullable();
            $table->json('permissions')->nullable();
            $table->boolean('hide_if_authenticated')->default(false)->index();
            $table->boolean('hide_if_guest')->default(false)->index();
            $table->timestamp('visible_from')->nullable();
            $table->timestamp('visible_until')->nullable();

            // Cache
            $table->boolean('enable_cache')->default(true)->index();
            $table->unsignedSmallInteger('cache_ttl')->default(60); // minutos

            // Auditoria
            $table->unsignedMediumInteger('created_by')->nullable()->index();
            $table->unsignedMediumInteger('updated_by')->nullable()->index();

            $table->timestamps();

            // Indices
            $table->index(['site_id', 'type']);
            $table->index(['site_id', 'type', 'slug']);

            // Relaciones
            $table->foreign('site_id')->references('id')->on('website_sites')->cascadeOnDelete();
            $table->foreign('seo_profile_id')->references('id')->on('website_seo_profiles')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_contents');
    }
};
