<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Database\Seeders;

use Koneko\VuexyAdmin\Support\Seeders\Base\AbstractDataSeeder;
use Koneko\VuexyAdmin\Support\Traits\Seeders\HandlesFileSeeders;
use Koneko\VuexyWebsiteAdmin\Models\{WebsiteSite, WebsiteTemplate};

class WebsiteSiteSeeder extends AbstractDataSeeder
{
    use HandlesFileSeeders;

    // Datos del Modelo
    protected string $model          = WebsiteSite::class;
    protected string|array $uniqueBy = 'domain';

    // Ruta del archivo de datos
    //protected string $targetFile = 'website_sites.json';

    protected function sanitizeRow(array $row): array
    {
        $template = WebsiteTemplate::where('slug', $row['template_slug'])->firstOrFail();

        $row['template_id'] = $template->id ?? null;
        unset($row['template_slug']);

        return $row;
    }

}
