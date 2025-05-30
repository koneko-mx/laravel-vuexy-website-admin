<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Database\Seeders;

use Koneko\VuexyAdmin\Support\Seeders\Base\AbstractDataSeeder;
use Koneko\VuexyAdmin\Support\Traits\Seeders\HandlesFileSeeders;
use Koneko\VuexyWebsiteAdmin\Models\{WebsiteMenuItem, WebsiteMenu};

class WebsiteMenuItemSeeder extends AbstractDataSeeder
{
    use HandlesFileSeeders;

    // Datos del Modelo
    protected string $model          = WebsiteMenuItem::class;
    protected string|array $uniqueBy = ['menu_id', 'title'];

    // Ruta del archivo de datos
    protected string $targetFile = 'website_menus_web_info.json';

    protected function sanitizeRow(array $row): array
    {
        $menu = WebsiteMenu::where('slug', $row['menu_slug'])->firstOrFail();

        $row['menu_id'] = $menu->id;
        unset($row['menu_slug']);

        // Asegurar que title sea array
        if (isset($row['title']) && is_string($row['title'])) {
            $decoded = json_decode($row['title'], true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $row['title'] = $decoded;
            }
        }

        return $row;
    }

}
