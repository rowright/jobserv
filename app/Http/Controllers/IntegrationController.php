<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IntegrationController extends Controller
{
    public function index()
    {
        return view('app.integration.index');
    }
}
