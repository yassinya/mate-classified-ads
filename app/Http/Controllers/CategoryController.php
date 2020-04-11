<?php

namespace App\Http\Controllers;

use App\Services\Slug;
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


    public function showCategoriesManagement()
    {
        return view('admin.categories.index');
    }

    public function createCategory(Request $req)
    {
        $req->validate([
            'category_name' => ['required', 'string', 'max:255'],
            'category_color' => ['required', 'string', 'max:255'],
        ]);

        $cat = new Category();
        $cat->name = $req->category_name;
        $cat->color_hex = $req->category_color;

        if($req->has('parent_id') && $req->parent_id !== '-'){
            $cat->parent_id = $req->parent_id;
        }

        $slug = new Slug();
        $cat->slug = $slug->make($cat, $cat->name, $cat->id);;
        $cat->save();
        
        return redirect()->back()->with(['success' => 'Category successfully saved']);
    }

    public function showEditCategoryForm($id)
    {
        $category = Category::whereId($id)->first();

        if(!$category){
            abort(404);
        }

        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    public function updateCategory(Request $req)
    {
        $req->validate([
            'category_name' => ['required', 'string', 'max:255'],
            'category_color' => ['required', 'string', 'max:255'],
        ]);

        $cat =  Category::whereId($req->category_id)->first();
        $cat->name = $req->category_name;

        if($req->has('parent_id') && $req->parent_id !== '-'){
            $cat->parent_id = $req->parent_id;
        }else{
            $cat->parent_id = null;
        }

        $cat->name = $req->category_name;
        $cat->color_hex = $req->category_color;


        $slug = new Slug();
        $cat->slug = $slug->make($cat, $cat->name, $cat->id);;
        $cat->save();
        
        return redirect()->back()->with(['success' => 'Successfully update']);
    }

    public function deleteCategory(Request $req){

        $cat =  Category::whereId($req->category_id)->with('children')->first();
        // delete and unlink its children categories
        foreach ($cat->children as $c) {
            $c->parent_id = null;
            $c->save();
        }

        $cat->delete();

        return redirect()->route('admin.categories');
    }
}
