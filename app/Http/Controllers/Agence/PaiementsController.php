<?php

namespace App\Http\Controllers\Agence;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaiementsController extends Controller
{
    //
    public function index()
    {
        return view('paiements.index');

    }
}
