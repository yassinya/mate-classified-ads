<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\User;
use App\Models\AdImage;
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
        $users = User::orderBy('id', 'desc')->get()->take(10);
        $numberOfCurrentMonthSignUps = User::whereMonth('created_at',date('m'))->count();
        $numberOfCurrentMonthAds = Ad::whereMonth('created_at',date('m'))->count();
        $numberOfCurrentMonthAds = Ad::whereMonth('created_at',date('m'))->count();
        $numberOfCurrentImgs = AdImage::whereMonth('created_at',date('m'))->count();

        return view('admin.home', [
            'pendingAds' => $pendingAds,
            'users' => $users,
            'numberOfCurrentMonthSignUps' => $numberOfCurrentMonthSignUps,
            'numberOfCurrentMonthAds' => $numberOfCurrentMonthAds,
            'numberOfCurrentImgs' => $numberOfCurrentImgs,
        ]);
    }
}
