<?php

namespace Koneko\VuexyWebsiteAdmin\Database\Seeders;

use Koneko\VuexyAdmin\Support\Seeders\Base\AbstractDataSeeder;
use Koneko\VuexyAdmin\Support\Traits\Seeders\HandlesFileSeeders;
use Koneko\VuexyWebsiteAdmin\Models\{WebsiteContent, WebsiteSeoProfile, WebsiteSite};

class WebsiteContentSeeder extends AbstractDataSeeder
{
    use HandlesFileSeeders;

    // Datos del Modelo
    protected string $model          = WebsiteContent::class;
    protected string|array $uniqueBy = ['site_id', 'slug'];

    // Ruta del archivo de datos
    //protected string $targetFile     = 'website_contents.json';

    protected function sanitizeRow(array $row): array
    {
        $row = array_merge($row, [
            'site_id'         => $this->findSiteId($row['site_domain']),
            'seo_profile_id'  => isset($row['seo_profile_slug']) ? $this->findSeoProfileId($row['seo_profile_slug']) : null,
        ]);

        return $row;
    }

    protected function findSiteId($domain): ?int
    {
        return WebsiteSite::where('domain', $domain)->first()?->id;
    }

    protected function findSeoProfileId($slug): ?int
    {
        return WebsiteSeoProfile::where('slug', $slug)->first()?->id;
    }
}
