<?php

namespace Koneko\VuexyWebsiteAdmin\Database\Seeders;

use Koneko\VuexyAdmin\Support\Seeders\Base\AbstractDataSeeder;
use Koneko\VuexyAdmin\Support\Traits\Seeders\HandlesFileSeeders;
use Koneko\VuexyWebsiteAdmin\Models\{WebsiteContent,WebsiteSeoProfile};

class WebsiteContentSeeder extends AbstractDataSeeder
{
    use HandlesFileSeeders;

    // Datos del Modelo
    protected string $model          = WebsiteContent::class;
    protected string|array $uniqueBy = ['slug'];

    // Ruta del archivo de datos
    protected string $targetFile     = 'website_contents.json';

    protected function sanitizeRow(array $row): array
    {
        return array_merge($row, [
            'created_by'      => $this->resolveSeederUserId(),
            'updated_by'      => $this->resolveSeederUserId(),
            'is_draft'        => $row['is_draft'] ?? false,
            'is_sensitive'    => $row['is_sensitive'] ?? false,
            'seo_profile_id'  => $this->findSeoProfileId($row['seo_profile_id']),
        ]);
    }

    protected function findSeoProfileId($slug): ?int
    {
        return WebsiteSeoProfile::where('slug', $slug)->first()?->id;
    }

    protected function resolveSeederUserId(): ?int
    {
        return config('seeder.default_user_id') ?? 1;
    }
}
