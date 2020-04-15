<?php

namespace App\Http\ViewComposers;

use App\Models\Ad;
use App\Models\Region;
use App\Models\AdImage;
use Illuminate\View\View;

class StatisticsComposer
{
    public $todayAdsCount = 0;
    public $yesterdayAdsCount = 0;
    public $lastWeekAdsCount = 0;
    public $adsCount = 0;
    public $imagesCount = 0;

    /**
     * Create a Region composer.
     *
     * @return void
     */
    public function __construct()
    {
        $this->todayAdsCount = Ad::whereDay('created_at', now()->day)
                                 ->withoutGlobalScopes(['reviewed', 'suspended', 'conrirmed'])
                                 ->count();
        $this->yesterdayAdsCount = Ad::whereDay('created_at', now()->yesterday())
                                     ->withoutGlobalScopes(['reviewed', 'suspended', 'conrirmed'])
                                     ->count();
        $this->lastWeekAdsCount = Ad::whereBetween('created_at', [now()->subWeeks(1)->startOfWeek(), now()->subWeeks(1)->endOfWeek()])
                                     ->withoutGlobalScopes(['reviewed', 'suspended', 'conrirmed'])
                                     ->count();
        $this->adsCount = Ad::withoutGlobalScopes(['reviewed', 'suspended', 'conrirmed'])
                            ->count();
        $this->imagesCount = AdImage::count();

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
            'todayAdsCount' => $this->todayAdsCount,
            'yesterdayAdsCount' => $this->yesterdayAdsCount,
            'lastWeekAdsCount' => $this->lastWeekAdsCount,
            'adsCount' => $this->adsCount,
            'imagesCount' => $this->imagesCount,
        ]);
    }
}