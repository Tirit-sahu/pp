<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;


class Dashboard extends Controller
{
    public function index()
    {
        return view('dashboard');
    }
}
