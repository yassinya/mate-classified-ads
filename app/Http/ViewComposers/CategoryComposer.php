<?php

namespace App\Http\ViewComposers;

use App\Models\Category;
use Illuminate\View\View;

class CategoryComposer
{
    public $categories = [];

    /**
     * Create a category composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->categories = Category::whereNull('parent_id')
                                    ->with('children', 'children.ads','ads')
                                    ->get();
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'categories' => $this->categories,
        ]);
    }
}