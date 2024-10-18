<?php

namespace Mzm\Ilogin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mzm\Ilogin\Services\SsoServices;

class SsoController extends Controller
{

    protected $ssoServices;

    public function __construct(SsoServices $ssoServices)
    {
        $this->ssoServices = $ssoServices;
    }

    /**
     * Provision a new web server.
     */
    public function __invoke()
    {
        // Check user data and handle redirection
        return $this->ssoServices->verify();
    }
}
