<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    // show merchant list
    public function index(Request $request) {
        return Merchant::all();
    }

    // delete all merchant
    public function destroy(Request $request) {
        Merchant::whereNotNull('id')->delete();

        return "success!";
    }
}
