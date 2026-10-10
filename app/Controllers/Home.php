<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return redirect()->to(session('user_id') ? '/dashboard' : '/login');
    }
}
