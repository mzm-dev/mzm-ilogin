<?php

namespace Mzm\Ilogin\View\Components;

use Illuminate\View\Component;

class LoginButton extends Component
{
    public $enable;
    public $url;

    public function __construct()
    {
        $this->enable = true;//config('ilogin.enable');
        $this->url = 'https://sso.ns.test';config('ilogin.api_url');
    }

    public function render()
    {
        return view('ilogin::components.loginbutton');
    }
}
