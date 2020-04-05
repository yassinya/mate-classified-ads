<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function showHomePage(Request $req)
    {
        $filters = $req->only(['region', 'city']);
        $categoriesWithAds = Category::whereNull('parent_id')
                                     ->whereHas('ads', function($q) use($filters){
                                         $q->filter($filters);
                                     })
                                     ->with('children', 'ads')
                                     ->get();

        // TODO return 404

        return view('home', ['categoriesWithAds' => $categoriesWithAds]);
    }

    public function showDashboard(){
        $pendingAds = Ad::with('images', 'images.sizes')->pending()->get();

        return view('admin.home', [
            'pendingAds' => $pendingAds,
        ]);
    }
}
