<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    // show outlet list
    public function index(Request $request) {
        return Outlet::all();
    }
}
