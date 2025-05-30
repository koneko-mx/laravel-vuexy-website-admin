<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\Http\Controllers;

use Illuminate\Routing\Controller;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function generalIndex()
    {
        return view('vuexy-website-admin::settings.general.index');
    }

    public function socialIndex()
    {
        return view('vuexy-website-admin::settings.social.index');
    }

    public function indexingIndex()
    {
        return view('vuexy-website-admin::settings.indexing.index');
    }
}
