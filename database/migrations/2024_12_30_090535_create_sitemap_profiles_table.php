<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sitemap_profiles', function (Blueprint $table) {
            $table->smallIncrements('id');

            $table->unsignedSmallInteger('site_id')->index();        // Soporte multisite

            $table->string('name');           // Nombre del perfil: 'Productos', 'Páginas CMS'
            $table->string('slug')->unique(); // Clave técnica

            $table->string('entity_type')->nullable(); // Ej: App\Models\Product
            $table->string('generator_class')->nullable(); // Clase que implementa SitemapUrlGeneratorInterface

            $table->boolean('is_active')->default(true)->index();
            // Auditoría
            $table->unsignedMediumInteger('created_by')->nullable()->index();
            $table->unsignedMediumInteger('updated_by')->nullable()->index();

            $table->timestamps();

            // Indices
            $table->index(['site_id', 'slug']);
            $table->index(['site_id', 'slug', 'is_active']);

            // Relaciones
            $table->foreign('site_id')->references('id')->on('website_sites')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sitemap_profiles');
    }
};
