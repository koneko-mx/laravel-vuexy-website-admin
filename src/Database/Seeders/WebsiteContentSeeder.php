<?php

namespace Koneko\VuexyWebsiteAdmin\Database\Seeders;

use Koneko\VuexyAdmin\Support\Seeders\Base\AbstractDataSeeder;
use Koneko\VuexyAdmin\Support\Traits\Seeders\HandlesFileSeeders;
use Koneko\VuexyWebsiteAdmin\Models\{WebsiteContent, WebsiteSeoProfile, WebsiteSite, WebsiteTemplate};

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
            'is_draft'        => $row['is_draft'] ?? false,
            'is_sensitive'    => $row['is_sensitive'] ?? false,
            'site_id'         => $this->findSiteId($row['site_domain']),
            'seo_profile_id'  => isset($row['seo_profile_slug']) ? $this->findSeoProfileId($row['seo_profile_slug']) : null,
            'template_id'     => isset($row['template_slug']) ? $this->findTemplateId($row['template_slug']) : null,
        ]);

        unset($row['site_domain'], $row['seo_profile_slug'], $row['template_slug']);

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

    protected function findTemplateId($slug): ?int
    {
        return WebsiteTemplate::where('slug', $slug)->first()?->id;
    }
}
