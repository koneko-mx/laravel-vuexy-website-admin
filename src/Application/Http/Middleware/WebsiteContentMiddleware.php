<?php

namespace Koneko\VuexyWebsiteAdmin\Application\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, View};
use Koneko\VuexyWebsiteAdmin\Models\WebsiteContent;
use Symfony\Component\HttpKernel\Exception\HttpException;

class WebsiteContentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $slug = $request->route('slug');


        /*
        $site = app('currentSite');

        $content = WebsiteContent::query()
            ->with(['seoProfile'])
            ->where('site_id', $site->id)
            ->bySlug($slug)
            ->firstOrFail();

        if ($request->routeIs('website.preview') && $request->hasValidSignature()) {
            View::share('_isPreview', true);

        } else {
            if ($content->is_draft && !Auth::check()) {
                throw new HttpException(403, 'Contenido no publicado.');
            }

            $now = now();
            if (
                ($content->visible_from && $content->visible_from > $now) ||
                ($content->visible_until && $content->visible_until < $now)
            ) {
                throw new HttpException(403, 'Contenido no disponible.');
            }

            $user = Auth::user();
            if (!empty($content->roles) && !$user?->hasAnyRole($content->roles)) {
                throw new HttpException(403, 'Acceso restringido.');
            }

            if (!empty($content->permissions) && !$user?->hasAnyPermission($content->permissions)) {
                throw new HttpException(403, 'Permiso insuficiente.');
            }
        }

        $seo     = $content->getEffectiveSeoMetadata();
        $layout  = $content->template ?? $site->template ?? 'vuexy-website-layout-porto';
        $variant = $content->type ?? 'page';

        View::share([
            '_content'  => $content,
            '_seo'      => $seo,
            '_template' => $layout,
            '_variant'  => $variant,
        ]);
        */

        return $next($request);
    }
}
