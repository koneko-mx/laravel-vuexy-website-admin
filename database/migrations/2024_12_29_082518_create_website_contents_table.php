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
            $table->string('type', 16)->default('page')->index();   // Enum: Content, Landing, Product, Category Blog, Partial
            $table->json('keywords')->nullable();

            // Metadata
            $table->string('title')->index();                       // Título del website
            $table->string('slug')->index();

            $table->mediumText('description')->nullable();          // Descripción del website
            $table->string('author')->nullable();                   // Autor del website
            $table->string('copyright')->nullable();                // Copyright del website

            $table->string('canonical_url')->nullable()->index();   // Canonical para root
            $table->string('favicon_ns')->nullable();               // Favicon del website

            // SEO
            $table->unsignedSmallInteger('seo_profile_id')->nullable()->index();
            $table->unsignedSmallInteger('template_id')->nullable()->index();

            // Render
            //$table->string('render_mode', 16)->default('static');
            //$table->string('block_mode', 16)->default('db');
            //$table->string('source', 16)->default('db');
            //$table->string('render_as')->nullable();

            // Content
            //$table->text('content')->nullable();
            $table->json('header_blocks')->nullable();
            $table->json('content_blocks')->nullable();
            $table->json('footer_blocks')->nullable();

            // Robots Directives
            $table->boolean('noindex')->nullable();
            $table->boolean('nofollow')->nullable();

            // Tipos de schema adicionales
            $table->json('schema_org')->nullable();

            // Idioma y Geolocalización
            $table->string('locale', 8)->default('es-MX')->index(); // Para SEO internacional
            $table->json('geo_location')->nullable();           // meta geo.region y geo.placename

            // Open Graph
            $table->string('og_type')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_url')->nullable();
            $table->string('og_site_name')->nullable();

            // Twitter Card
            $table->string('twitter_card')->default('summary_large_image');
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->string('twitter_site')->nullable();
            $table->string('twitter_creator')->nullable();

            // JSON-LD opcional (almacenado como bloque JSON)
            $table->json('json_ld')->nullable();

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
            $table->unsignedSmallInteger('cache_ttl')->nullable();

            // Auditoria
            $table->unsignedMediumInteger('created_by')->nullable()->index();
            $table->unsignedMediumInteger('updated_by')->nullable()->index();

            $table->timestamps();

            // Indices
            $table->unique(['site_id', 'slug']);
            $table->index(['site_id', 'type']);
            $table->index(['site_id', 'type', 'slug']);

            // Relaciones
            $table->foreign('site_id')->references('id')->on('website_sites')->cascadeOnDelete();
            $table->foreign('template_id')->references('id')->on('website_templates')->nullOnDelete();
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
