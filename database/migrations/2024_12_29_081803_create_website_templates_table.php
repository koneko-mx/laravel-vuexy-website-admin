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
        Schema::create('website_templates', function (Blueprint $table) {
            $table->smallIncrements('id');

            $table->string('title')->index();
            $table->string('slug')->unique();

            $table->string('layout')->index();
            $table->string('theme_color')->nullable();
            $table->json('favicon')->nullable();
            $table->json('config')->nullable();

            $table->boolean('is_active')->default(true)->index();

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
        Schema::dropIfExists('website_templates');
    }
};
