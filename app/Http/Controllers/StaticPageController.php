<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    /**
     * درباره ما.
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * تماس با ما
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     *  سوالات متداول
     */
    public function faq()
    {
        return view('pages.faq');
    }
}
