<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Database\Seeders;

use Koneko\VuexyAdmin\Support\Seeders\Base\AbstractDataSeeder;
use Koneko\VuexyAdmin\Support\Traits\Seeders\HandlesFileSeeders;
use Koneko\VuexyWebsiteAdmin\Models\WebsiteTemplate;

class WebsiteTemplateSeeder extends AbstractDataSeeder
{
    use HandlesFileSeeders;

    // Datos del Modelo
    protected string $model          = WebsiteTemplate::class;
    protected string|array $uniqueBy = 'slug';

    // Ruta del archivo de datos
    //protected string $targetFile = 'website_templates.json';
}
