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
            $table->string('domain')->unique();              // Dominio principal (sin protocolo)

            // Formato de Titulo
            $table->string('title', 96)->index();

            // Robots Directives
            $table->string('robots_mode', 16)->default('content')->index(); // ['suspended','site','content']
            $table->boolean('site_noindex')->default(false)->index();
            $table->boolean('site_nofollow')->default(false)->index();
            $table->boolean('www_redirect')->default(true);
            $table->boolean('force_https')->default(true);

            // Autor, Brand y Copyright
            $table->string('author', 70)->nullable();
            $table->string('brand_name', 70)->nullable();
            $table->string('copyright', 160)->nullable();
            $table->string('slogan')->nullable();

            // Template por defecto
            $table->string('package')->nullable()->index();
            $table->string('layout')->nullable()->index();
            $table->string('theme_color', 16)->nullable();

            // Estado y páginas especiales
            $table->string('status', 16)->default('coming_soon')->index();
            $table->unsignedMediumInteger('coming_soon_content_id')->nullable()->index();
            $table->unsignedMediumInteger('maintenance_content_id')->nullable()->index();

            // Auditoría
            $table->unsignedMediumInteger('created_by')->nullable()->index();
            $table->unsignedMediumInteger('updated_by')->nullable()->index();
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
        Schema::dropIfExists('website_sites');
    }
};
