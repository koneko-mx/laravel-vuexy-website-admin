<?php

namespace Koneko\VuexyWebsiteAdmin\Http\Controllers;

use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vuexy-website-admin::faq.index');
    }

}
