<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{

    public $title;

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function render()
    {
        if(auth()->user()->role->type == 'master') {
            return view('master.layouts.app');
        } else {
            return view('tenants.layouts.app');
        }
    }
}
