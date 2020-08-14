<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Dashboard
     *
     * @return View
     */
    public function index()
    {
        return view('Admin\Dashboard\dashboard');
    }
}

