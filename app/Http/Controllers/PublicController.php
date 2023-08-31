<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index(Request $request)
    {

        return view('home');
    }
}
