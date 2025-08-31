<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\Http\Controllers;

use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\View;
use Koneko\VuexyAdmin\Application\UX\Breadcrumbs\Breadcrumbs;
use Koneko\VuexyWebsiteAdmin\Application\Enums\Websites\WebsiteTab;
use Koneko\VuexyWebsiteAdmin\Models\WebsiteSite;

class WebsitesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): ViewContract
    {
        $sites = WebsiteSite::all();

        return view('vuexy-website-admin::sites.index', compact('sites'));
    }

    public function site(WebsiteSite $site, $tab = 'general'): ViewContract
    {
        $tabEnum = WebsiteTab::tryFrom($tab) ?? WebsiteTab::General;

        Breadcrumbs::extend([
            [
                'name'   => $site->domain,
                'link'   => route('admin.website-admin.websites.manager.site', [$site, 'general']),
                'active' => $tabEnum === WebsiteTab::General,
            ],
            [
                'name'   => $tabEnum->label(),
            ],
        ]);

        return view('vuexy-website-admin::sites.site.index', [
            'site' => $site,
            'tab'  => $tabEnum->value,
        ]);
    }

}
