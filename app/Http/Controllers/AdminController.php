<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard() {
        $settings = '111';
        return view('pages.dashboard', compact('settings'));
    }
}
