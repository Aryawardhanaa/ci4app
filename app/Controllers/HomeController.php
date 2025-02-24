<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): string
    {
        return view('landing');
    }
    public function showTabs(): string
    {
        return view('home');
    }
}
