<?php

namespace Koneko\VuexyWebsiteAdmin\Http\Controllers;

use App\Http\Controllers\Controller;

class ContactInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vuexy-website-admin::contact-info.index');
    }

}
