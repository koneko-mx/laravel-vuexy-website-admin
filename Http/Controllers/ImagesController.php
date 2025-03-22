<?php

namespace Koneko\VuexyWebsiteAdmin\Http\Controllers;

use App\Http\Controllers\Controller;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vuexy-website-admin::images.index');
    }

}
