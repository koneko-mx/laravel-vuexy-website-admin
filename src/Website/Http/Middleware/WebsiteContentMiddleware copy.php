<?php

namespace Koneko\VuexyAdmin\Application\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Koneko\VuexyWebsiteAdmin\Models\WebsiteContent;

class __WebsiteContentMiddlewareCopy__2
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
        if ($content->status == "draft" && !Auth::check()) {
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


class __WebsiteContentMiddleware__3
{
    public function handle(Request $request, Closure $next)
    {
        if (!str_contains($request->header('Accept'), 'text/html')) {
            return $next($request);
        }

        $siteContext = app(SiteContext::class);

        if ($siteContext->content === null) {
            throw new HttpException(404, 'Contenido no publicado.');
        }

        /*
        $contact = [
            'email' => $site->contact_email ?? '',
            'phone' => $site->contact_phone ?? '',
            'address' => $site->contact_address ?? '',
        ];

        /*
        // Variables visuales generales (favicon, logo, layout, etc.)
        $layoutVars = app(WebsiteLayoutVarsBuilder::class)->forSite($site)->get();

        // Variables SEO (title, meta, index, canonical, etc.)
        $seoVars = app(WebsiteSeoVarsBuilder::class)->forSite($site)->get();

        // Variables sociales (twitter, opengraph, etc.)
        $socialVars = app(WebsiteSocialVarsBuilder::class)->forSite($site)->get();
        */

        if ($request->routeIs('website.preview') && $request->hasValidSignature()) {
            View::share('_isPreview', true);

        } else {
            if ($siteContext->content->status == "draft" && !Auth::check()) {
                throw new HttpException(403, 'Contenido no publicado.');
            }

            $now = now();

            if (
                ($siteContext->content->visible_from && $siteContext->content->visible_from > $now) ||
                ($siteContext->content->visible_until && $siteContext->content->visible_until < $now)
            ) {
                throw new HttpException(403, 'Contenido no disponible.');
            }

            $user = Auth::user();

            if (!empty($siteContext->content->roles) && !$user?->hasAnyRole($siteContext->content->roles)) {
                throw new HttpException(403, 'Acceso restringido.');
            }

            if (!empty($siteContext->content->permissions) && !$user?->hasAnyPermission($siteContext->content->permissions)) {
                throw new HttpException(403, 'Permiso insuficiente.');
            }
        }


        // Compartir a todas las vistas públicas
        View::share([
            '_layout'  => $siteContext->getLayout(),
            '_seo'     => $siteContext->getSeo(),
            '_social'  => $siteContext->getSocial(),
            '_contact' => $siteContext->getContact(),
            '_headerBlocks'  => $siteContext->getHeaderBlocks(),
            '_contentBlocks' => $siteContext->getContentBlocks(),
            '_footerBlocks'  => $siteContext->getFooterBlocks(),
        ]);


        return $next($request);
    }
}
