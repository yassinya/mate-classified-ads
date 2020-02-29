<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function showHomePage()
    {
        $ads = Ad::all();

        // TODO return 404

        return view('home', ['ads' => $ads]);
    }
}
