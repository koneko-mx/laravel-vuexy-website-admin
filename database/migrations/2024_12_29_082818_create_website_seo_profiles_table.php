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
        Schema::create('website_seo_profiles', function (Blueprint $table) {
            $table->mediumIncrements('id');

            // Dueño polimórfico
            $table->string('seoable_type', 191);
            $table->unsignedMediumInteger('seoable_id');
            $table->string('scope', 16)->default('content')->index(); // 'site' | 'content'

            // Schema.org
            $table->string('schema_mode', 12)->default('inherit')->index(); // inherit|override|disable
            $table->json('schema_org')->nullable();

            // Favicon
            $table->string('favicon_mode', 12)->default('inherit')->index();
            $table->json('favicon')->nullable();

            // Locale
            $table->string('locale_mode', 12)->default('inherit')->index();
            $table->string('locale', 8)->default('es-MX')->index();

            // Open Graph
            $table->string('og_mode', 12)->default('inherit')->index(); // inherit|override|disable
            $table->string('og_type')->nullable();
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_url')->nullable();
            $table->string('og_site_name')->nullable();

            // Twitter Card
            $table->string('twitter_mode', 12)->default('inherit')->index();
            $table->string('twitter_card')->nullable();
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->string('twitter_site')->nullable();
            $table->string('twitter_creator')->nullable();

            // Indices
            $table->unique(['seoable_type','seoable_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_seo_profiles');
    }
};
