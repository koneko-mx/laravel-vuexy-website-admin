<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\Http\Controllers;

use Illuminate\Routing\Controller;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sitemapIndex()
    {
        return view('vuexy-website-admin::seo.sitemap.index');
    }

    public function jsonldIndex()
    {
        return view('vuexy-website-admin::seo.jsonld.index');
    }

    public function robotsIndex()
    {
        return view('vuexy-website-admin::seo.robots.index');
    }

    public function manifestIndex()
    {
        return view('vuexy-website-admin::seo.manifest.index');
    }

    public function canonicalIndex()
    {
        return view('vuexy-website-admin::seo.canonical.index');
    }

    public function socialCardsIndex()
    {
        return view('vuexy-website-admin::seo.social-cards.index');
    }
}
