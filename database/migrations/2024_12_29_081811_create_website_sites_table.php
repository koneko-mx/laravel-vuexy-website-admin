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
            $table->json('keywords')->nullable();

            $table->string('title')->index();
            $table->string('description')->nullable();
            $table->string('author')->nullable();
            $table->string('copyright')->nullable();

            // Robots Directives
            $table->boolean('noindex')->default(false);
            $table->boolean('nofollow')->default(false);
            $table->boolean('allow_overwrite_robots')->default(false);

            $table->boolean('force_https')->default(true);
            $table->string('www_alias', 16)->default('redirect')->index();   // none, redirect no-www, www

            // SEO
            $table->unsignedSmallInteger('template_id')->nullable()->index();

            // Configuración
            $table->json('config')->nullable();              // favicon, theme, brand, CDN, etc.

            // Estado
            $table->string('status', 16)->default('active')->index();   // active, maintenance, coming_soon

            // Auditoría
            $table->unsignedMediumInteger('created_by')->nullable()->index();
            $table->unsignedMediumInteger('updated_by')->nullable()->index();
            $table->timestamps();

            // Relaciones
            $table->foreign('template_id')->references('id')->on('website_templates')->restrictOnDelete();
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
