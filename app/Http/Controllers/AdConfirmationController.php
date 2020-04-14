<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\AdConfirmation;

class AdConfirmationController extends Controller
{
    public function confirmAd($token)
    {
        $setting = Setting::find(1);

        $ad = AdConfirmation::whereToken($token)
                            ->with('ad')
                            ->first()
                            ->ad;
        // return 404 if confirmation token does not exist or the ad has already been confirmed
        if(! $ad || $ad->confirmed_at != null){
            abort(404);
        }

        $ad->confirmed_at = now();
        $ad->save();

        if($setting->require_ads_revision){
            return view('ads.confirmation')->withMsg('Successfully confirmed, your ad is currently awaiting review.');
        }else{
            return redirect()->route('ads.show.single', ['slug' => $ad->slug])
                             ->with(['success-msg' => 'Successfully confirmed, your ad is live']);
        }
    }
}
