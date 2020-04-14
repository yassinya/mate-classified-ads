<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function showSettings(){
        $setting = Setting::find(1);
        
        return view('admin.settings', [
            'setting' => $setting
        ]);
    }

    public function update(Request $req){
        
        $setting = Setting::find(1);

        if($req->has('require_ads_revision')){
            $setting->require_ads_revision = true;
        }else{
            $setting->require_ads_revision = false;
        }

        $setting->ad_max_img_upload = $req->ad_max_img_upload;
        $setting->save();

        return redirect()->back()->with(['success' => 'Successfully update']);
    }
}
