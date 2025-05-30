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
        Schema::create('website_sites', function (Blueprint $table) {
            $table->smallIncrements('id');

            // Identidad
            $table->string('name')->index();                 // Nombre visible en admin
            $table->string('slug')->unique();                // Clave técnica
            $table->string('domain')->unique();              // Dominio principal (sin protocolo)
            $table->string('template')->nullable();          // Componente layout activo

            // Estado
            $table->string('status', 16)->default('active')->index();   // Estados especiales del sitio
            $table->boolean('is_indexable')->default(true)->index();    // SEO: permitir indexado o no

            // SEO
            $table->unsignedSmallInteger('seo_profile_id')->nullable()->index();
            $table->string('canonical_url')->nullable();     // Canonical para root

            // Configuración
            $table->json('config')->nullable();              // favicon, theme, brand, CDN, etc.

            // Auditoría
            $table->unsignedMediumInteger('created_by')->nullable()->index();
            $table->unsignedMediumInteger('updated_by')->nullable()->index();
            $table->timestamps();

            // Indices
            $table->index(['slug', 'status', 'is_indexable']);

            // Relaciones
            $table->foreign('seo_profile_id')->references('id')->on('website_seo_profiles')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->restrictOnDelete();
        });

        Schema::table('website_seo_profiles', function (Blueprint $table) {
            $table->foreign('site_id')->references('id')->on('website_sites')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_sites');

        Schema::table('website_seo_profiles', function (Blueprint $table) {
            $table->dropForeign(['site_id']);
        });
    }
};
