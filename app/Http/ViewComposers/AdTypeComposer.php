<?php

namespace App\Http\ViewComposers;

use App\Models\AdType;
use Illuminate\View\View;

class AdTypeComposer
{
    public $adTypes = [];

    /**
     * Create a AdType composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->adTypes = AdType::all();
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
            'adTypes' => $this->adTypes,
        ]);
    }
}