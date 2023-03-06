<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

use App\Http\Requests\EmployeeRequest;
use Illuminate\Http\Request;
use Exception;

class AttachmentController extends Controller
{

    public function store (Request $request)
    {
        // return $request;
        foreach($request->file('photos') as $file)
        {
            $name = $file->getClientOriginalName();
            $file->storeAs('attachments/employeess/'.$request->employees_name, $file->getClientOriginalName(),'upload_attachments');

            // insert in image_table
            $images= new Image();
            $images->filename=$name;
            $images->imageable_id = $request->employees_id;
            $images->imageable_type = 'App\Models\employees';
            $images->save();
        }
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('Employee.All_Employee.show',$request->employees_id);
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
        Image::where('id',$request->id)->where('filename',$request->filename)->delete();
        session()->flash('success', __('site.has_been_transferred_successfully'));
        return redirect()->route('Employee.All_Employee.show',$request->employees_id);
    }

}//end of controller
