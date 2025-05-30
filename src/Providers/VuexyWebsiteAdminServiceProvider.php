<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Providers;

use Illuminate\Support\ServiceProvider;
use Koneko\VuexyAdmin\Support\Traits\Modules\KonekoModuleBoots;

class VuexyWebsiteAdminServiceProvider extends ServiceProvider
{
    use KonekoModuleBoots;

    public function register(): void
    {
        $this->registerKonekoModule(dirname(__DIR__));
    }
}
