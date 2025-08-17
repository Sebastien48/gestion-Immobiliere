<?php

namespace App\Http\Controllers\Agence;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationsController extends Controller
{
    //
    public function index(){
        return view('locations.index');
    }
}
