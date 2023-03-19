<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Writer\Ods\Settings;

class School_SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.School_settings');
    }

    public function store(Request $request)
    {
        // return $request;
        $request->validate(['school_email' => 'required|email',]);
        $ValidatedDated = $request->except('_token');
        if ($request->has('school_logo')) {
            $request->school_logo->store('school_uploads');
            $ValidatedDated['school_logo'] = $request->school_logo->hashName();
        }
        if ($request->hasFile('school_fav_icon')) {
            $request->school_fav_icon->store('school_uploads');
            $ValidatedDated['school_fav_icon'] = $request->school_fav_icon->hashName();
        }

        setting($ValidatedDated)->save();

        // return $ValidatedDated;
        return Redirect()->back();
    }
}