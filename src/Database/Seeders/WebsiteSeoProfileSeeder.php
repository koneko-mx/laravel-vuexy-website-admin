<?php

namespace Koneko\VuexyWebsiteAdmin\Database\Seeders;

use Koneko\VuexyAdmin\Support\Seeders\Base\AbstractDataSeeder;
use Koneko\VuexyAdmin\Support\Traits\Seeders\HandlesFileSeeders;
use Koneko\VuexyWebsiteAdmin\Models\WebsiteSeoProfile;

class WebsiteSeoProfileSeeder extends AbstractDataSeeder
{
    use HandlesFileSeeders;

    // Datos del Modelo
    protected string $model          = WebsiteSeoProfile::class;
    protected string|array $uniqueBy = 'slug';

    // Ruta del archivo de datos
    //protected string $targetFile = 'website_seo_profiles.json';

    protected function sanitizeRow(array $row): array
    {
        return array_merge($row, [
            'created_by' => $this->resolveSeederUserId(),
        ]);
    }

    /**
     * Opcional: usuario dummy o admin por defecto
     */
    protected function resolveSeederUserId(): int|null
    {
        return config('seeder.default_user_id', null); // Usa config si está definido
    }
}
