<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index()
    {
        return view('admin.index'); // Assuming you have an index view for the admin dashboard
    }
}
