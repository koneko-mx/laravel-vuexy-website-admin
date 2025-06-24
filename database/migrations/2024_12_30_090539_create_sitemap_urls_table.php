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
        Schema::create('sitemap_urls', function (Blueprint $table) {
            $table->mediumIncrements('id');

            $table->unsignedSmallInteger('sitemap_profile_id')->index();
            $table->string('url')->unique();

            $table->string('changefreq', 16)->default('weekly'); // Enum
            $table->decimal('priority', 2, 1)->default(0.5);
            $table->timestamp('lastmod')->nullable();

            $table->boolean('is_active')->default(true)->index();
            $table->json('alternate_locales')->nullable(); // SEO internacional

            // Auditoría
            $table->timestamps();

            // Indices
            $table->index(['sitemap_profile_id', 'is_active']);

            // Relaciones
            $table->foreign('sitemap_profile_id')->references('id')->on('sitemap_profiles')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sitemap_urls');
    }
};
