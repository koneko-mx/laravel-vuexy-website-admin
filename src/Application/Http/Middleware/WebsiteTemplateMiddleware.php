<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;
use Koneko\VuexyWebsiteAdmin\Website\UX\Content\WebsiteBreadcrumbsBuilderService;
use Koneko\VuexyWebsiteAdmin\Website\UX\Menu\WebsiteMenuBuilderService;
use Koneko\VuexyWebsiteAdmin\Website\UX\Template\WebsiteVarsBuilderService;

class WebsiteTemplateMiddleware
{
    public function handle($request, Closure $next)
    {
        // Aplicar configuración de layout antes de que la vista se cargue
        if (str_contains($request->header('Accept'), 'text/html')) {
            View::share([
                '_web'       => []//app(WebsiteVarsBuilderService::class)->getWebsiteVars(),
                //'_menu'        => app(WebsiteMenuBuilderService::class)->getForUser(),
                //'_breadcrumbs' => app(WebsiteBreadcrumbsBuilderService::class)->getBreadcrumbs(),
            ]);
        }

        return $next($request);
    }
}
