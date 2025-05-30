<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Koneko\VuexyWebsiteAdmin\Application\ConfigBuilders\Faq\FaqTableConfigBuilder;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function faqIndex(Request $request)
    {
        if ($request->ajax()) {
            return app(FaqTableConfigBuilder::class)
                ->getQueryBuilder($request)
                ->getJson();
        }
        return view('vuexy-website-admin::content.faq.index');
    }

    public function galleryIndex()
    {
        return view('vuexy-website-admin::content.gallery.index');
    }

    public function legalIndex()
    {
        return view('vuexy-website-admin::content.legal.index');
    }
}
