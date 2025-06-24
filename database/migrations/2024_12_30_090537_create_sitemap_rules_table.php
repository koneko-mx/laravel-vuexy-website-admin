<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sitemap_rules', function (Blueprint $table) {
            $table->mediumIncrements('id');

            $table->unsignedSmallInteger('sitemap_profile_id')->index();
            $table->string('rule_type');    // Ej: 'priority_override', 'exclude_flag', etc.
            $table->json('rule_data');      // JSON con parámetros

            $table->timestamps();

            // Indices
            $table->index(['sitemap_profile_id', 'rule_type']);

            // Relaciones
            $table->foreign('sitemap_profile_id')->references('id')->on('sitemap_profiles')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sitemap_rules');
    }
};
