<?php

namespace App\Http\Controllers;

use App\Models\Detail;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index(Service $service)
    {
        return view('service.index', ['service' => $service]);
    }

    public function show(Detail $detail)
    {
        return view('service.show', ['detail' => $detail]);
    }
}
