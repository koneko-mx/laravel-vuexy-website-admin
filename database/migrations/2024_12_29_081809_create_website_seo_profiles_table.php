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
            $table->smallIncrements('id');

            $table->string('title')->nullable()->index();           // Título del perfil
            $table->string('slug')->unique();
            $table->string('type', 16)->default('page')->index();   // Enum: Page, Landing, Product, Category Blog
            $table->json('keywords')->nullable();
            $table->mediumText('description')->nullable();          // Descripción del perfil

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

            // Auditoria
            $table->unsignedMediumInteger('created_by')->nullable();
            $table->unsignedMediumInteger('updated_by')->nullable();
            $table->timestamps();

            // Relaciones
            $table->foreign('created_by')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->restrictOnDelete();
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
