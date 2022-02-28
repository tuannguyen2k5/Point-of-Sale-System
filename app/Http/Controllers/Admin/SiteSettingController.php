<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use App\Http\Requests\SiteSettingRequest;

class SiteSettingController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function edit(Request $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $site_setting = SiteSetting::first();
        if ($site_setting) {
            return view('admin.site-settings.edit', compact('site_setting'));
        } else {
            $site_setting->title = config('site-settings.site_title');
            $site_setting->logo = config('site-settings.site_logo');

            return view('admin.site-settings.edit', compact('site_setting'));
        }
    }

    public function update(SiteSettingRequest $request)
    {
        $request->user()->authorizeRoles(['admin']);
        $data = $request->except('_method', '_token');

        if(isset($data['logo']))
        {
            $path = $this->_upload($request);
            if ($path) {
                $data['logo'] = $path;
            }
        } else {
            $data['logo'] = $data['old_logo'];
        }
        
        $site_setting = SiteSetting::first();
        $site_setting->title = $data['title'];
        $site_setting->logo = $data['logo'];
        $site_setting->save();
        config(['site-settings.site_title' => $data['title']]);
        config(['site-settings.site_logo' => $data['logo']]);
        
        return redirect(route('admin.site-settings.edit'))->with('success', __('Update Site Settings successfully!'));
    }

    private function _upload($request)
    {
        if ($request->hasFile('logo')) {
            $photo = $request->file('logo');
            $path = $photo->storeAs(
                'uploads',
                $photo->getClientOriginalName()
            );
            return $path;
        }
        return false;
    }
}
