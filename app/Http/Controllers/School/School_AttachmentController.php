<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\school_teachers;
use App\Models\school_images;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\EmployeeRequest;
use Illuminate\Http\Request;
use Exception;

class School_AttachmentController extends Controller
{

    public function store (Request $request)
    {
        // return $request;
        try{
        foreach($request->file('photos') as $file)
        { 
            // return $request;
            $name = $file->getClientOriginalName();
            $file->storeAs('attachments/employeess/'.$request->teachers_name, $file->getClientOriginalName(),'upload_attachments');
           
            // insert in image_table
            $images= new school_images(); 
            $images->filename=$name;
            $images->imageable_id = $request->teachers_id;
            $images->school_id = $request->school_id;
            $images->imageable_type = 'App\Models\school_teachers';
            $images->save();
        }
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('School.All_Teachers.show',$request->teachers_id);
    } catch (Exception $e) {
        dd($e);
        session()->flash('error',  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }
    }

    public function Download_attachment($employeessname, $filename)
    {
        // return $filename;
        return response()->download(public_path('attachments/employeess/'.$employeessname.'/'.$filename));
    }

    public function Delete_attachment(Request $request)
    {
        // Delete img in server disk
        Storage::disk('upload_attachments')->delete('attachments/employeess/'.$request->employees_name.'/'.$request->filename);

        // Delete in data
        school_images::where('id',$request->id)->where('filename',$request->filename)->delete();
        session()->flash('success', __('site.has_been_transferred_successfully'));
        return redirect()->route('School.All_Teachers.show',$request->employees_id);
    }

}//end of controller
