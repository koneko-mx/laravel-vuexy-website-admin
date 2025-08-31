<?php

namespace Koneko\VuexyWebsiteAdmin\Database\Seeders;

use Koneko\VuexyAdmin\Support\Seeders\Base\AbstractDataSeeder;
use Koneko\VuexyAdmin\Support\Traits\Seeders\HandlesFileSeeders;
use Koneko\VuexyWebsiteAdmin\Models\{WebsiteSeoProfile, WebsiteSite};
use Koneko\VuexyWebsiteAdmin\Application\Enums\WebsiteSeoProfile\WebsiteSeoProfileScope;

class WebsiteSeoProfileSeeder extends AbstractDataSeeder
{
    use HandlesFileSeeders;

    // Datos del Modelo
    protected string $model          = WebsiteSeoProfile::class;
    protected string|array $uniqueBy = 'id';

    protected function sanitizeRow(array $row): array
    {
        $website = WebsiteSite::where('domain', $row['site_domain'])->first();

        if ($website) {
            $row['seoable_type'] = WebsiteSite::class;
            $row['seoable_id']   = $website->id;
            $row['scope']        = WebsiteSeoProfileScope::Site->value;
        }

        return $row;
    }
}
