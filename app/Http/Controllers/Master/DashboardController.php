<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = array(
            'menu' => 'dashboard',
            'page' => 'Dashboard'
        );

        return view('master.dashboard', compact(
            'title'
        ));
    }
}
