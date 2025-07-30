<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    /**
     * نمایش صفحه درباره ما.
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * نمایش صفحه تماس با ما.
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * نمایش صفحه سوالات متداول.
     */
    public function faq()
    {
        return view('pages.faq');
    }
}
