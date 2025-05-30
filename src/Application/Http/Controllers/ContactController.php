<?php

declare(strict_types=1);

namespace Koneko\VuexyWebsiteAdmin\Application\Http\Controllers;

use Illuminate\Routing\Controller;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function infoIndex()
    {
        return view('vuexy-website-admin::contact.info.index');
    }

    public function formIndex()
    {
        return view('vuexy-website-admin::contact.form.index');
    }
}
