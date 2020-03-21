<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function showSingleCategory($slug, Request $req){
        $filters = $req->only(['region', 'city']);
        $category = Category::whereSlug($slug)
                            ->with(['ads' => function($q) use($filters){
                                $q->filter($filters);
                            }])
                            ->first();
        if(! $category){
            abort(404);
        }

        return view('categories.single-category', ['category' => $category]);
    }
}
