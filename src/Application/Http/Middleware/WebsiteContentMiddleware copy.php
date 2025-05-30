<?php

namespace Koneko\VuexyAdmin\Application\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Koneko\VuexyWebsiteAdmin\Models\WebsiteContent;

class WebsiteContentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $slug = $request->route('slug');

        /** @var WebsiteSite $site */
        $site = app('currentSite');

        /** @var WebsiteContent|null $content */
        $content = WebsiteContent::query()
            ->with(['seoProfile'])
            ->where('site_id', $site->id)
            ->bySlug($slug)
            ->firstOrFail();

        // 🛑 Bloqueo por estado
        if ($content->is_draft && !Auth::check()) {
            abort(403, 'Contenido no publicado.');
        }

        // 🛑 Fechas de visibilidad
        $now = now();
        if (
            $content->visible_from && $content->visible_from > $now ||
            $content->visible_until && $content->visible_until < $now
        ) {
            abort(403, 'Contenido no disponible.');
        }

        // 🔐 Roles o permisos
        if (!empty($content->roles) && !Auth::user()?->hasAnyRole($content->roles)) {
            abort(403, 'Acceso restringido.');
        }

        if (!empty($content->permissions) && !Auth::user()?->hasAnyPermission($content->permissions)) {
            abort(403, 'Permiso insuficiente.');
        }

        // 🧠 SEO + Layout + Vista pública
        $seo     = $content->getEffectiveSeoMetadata();
        $layout  = $content->template ?? $site->template ?? 'vuexy-website-layout-porto';
        $variant = $content->type ?? 'page';

        // 📤 Compartir variables globales a la vista pública
        View::share([
            '_content'  => $content,
            '_seo'      => $seo,
            '_template' => $layout,
            '_variant'  => $variant,
        ]);

        return $next($request);
    }
}
