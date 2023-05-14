<?php

namespace App\Http\Controllers;

class HomeController extends AdminBaseController
{
    function __construct()
    {
        $this->title = "TrustHR | Dashboard";
        $this->path = "dashboard/index";
    }
}
