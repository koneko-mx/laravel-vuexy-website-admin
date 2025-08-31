<?php

namespace Koneko\VuexyWebsiteAdmin\Application\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, View};
use Koneko\VuexyWebsiteAdmin\Application\Bootstrap\Context\SiteContext;
use Koneko\VuexyWebsiteAdmin\Models\{WebsiteContent, WebsiteSite};
use Symfony\Component\HttpKernel\Exception\HttpException;

class WebsiteContentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!str_contains($request->header('Accept'), 'text/html')) {
            return $next($request);
        }

        $siteContext = app(SiteContext::class);

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
