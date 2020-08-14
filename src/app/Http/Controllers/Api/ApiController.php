<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * APIController constructor.
     */
    public function __construct()
    {
        auth()->setDefaultDriver('api');
    }
}
