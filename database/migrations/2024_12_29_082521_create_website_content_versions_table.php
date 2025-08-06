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
        Schema::create('website_content_versions', function (Blueprint $table) {
            $table->mediumIncrements('id');

            $table->unsignedSmallInteger('website_content_id')->index();
            $table->string('version_label', 64)->index();
            $table->longText('content');
            $table->boolean('is_current')->default(false);
            $table->json('metadata')->nullable();

            // Auditoria
            $table->unsignedMediumInteger('created_by')->nullable();
            $table->unsignedMediumInteger('updated_by')->nullable();

            $table->timestamps();

            // Indices
            $table->index(['website_content_id', 'version_label']);
            $table->index(['website_content_id', 'is_current']);

            // Relaciones
            $table->foreign('website_content_id')->references('id')->on('website_contents')->cascadeOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->restrictOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_content_versions');
    }
};
