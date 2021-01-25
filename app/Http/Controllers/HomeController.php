<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Service;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'service' => Service::all(),
            'review' => Review::all()
        ]);
    }
}
