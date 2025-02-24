<?php

namespace App\Controllers;

class UserController extends BaseController
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
