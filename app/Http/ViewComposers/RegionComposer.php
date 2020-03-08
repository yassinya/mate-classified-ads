<?php

namespace App\Http\ViewComposers;

use App\Models\Region;
use Illuminate\View\View;

class RegionComposer
{
    public $regions = [];

    /**
     * Create a Region composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->regions = Region::with('cities')->get();
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
            'regions' => $this->regions,
        ]);
    }
}