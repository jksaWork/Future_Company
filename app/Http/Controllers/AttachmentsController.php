<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Attachments;
use App\Models\Offer;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(
            [
                'attachments' => 'required',
                'attachmentable' => 'required',
                'type' => 'required',
            ],
            ['required' => __('translation.attachment_is_required')]
        );

        // dd($request->type);
        $attachmentableArray = Attachments::getAttachableModel($request->type);
        // dd($attachmentableArray);
        // Get Attachable From And Route And Key From Function getAttachableModel
        [$attachmentableClass, $route, $routeKey] = $attachmentableArray;
        $attachmentable = $attachmentableClass::find($request->attachmentable);
        // dd($attachmentableArray);
        foreach ($request->attachments  as $key => $file) {
            $file_name =  $file->hashName();
            $file->store($routeKey . '/attachments',  'public');
            $attachment = new Attachments();
            $attachment->url = $file_name;
            $attachmentable->attachments()->save($attachment);
        }
        return redirect()->route($route, [$routeKey => $attachmentable->id])->with(['success' => __('translation.the_file_was_uploaded_success')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EmpAtatchment  $empAtatchment
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EmpAtatchment  $empAtatchment
     * @return \Illuminate\Http\Response
     */


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EmpAtatchment  $empAtatchment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $attach = Attachments::find($id);
        // Storage::delete(' $pathToFile ');
        $pathToFile = Storage::disk('Attachment')->getAdapter()->applyPathPrefix($attach->employee_id . '\\' . $attach->file_name);
        $attach->delete();
        return redirect()->route('employee.show', $attach->employee_id)->with(['success' => 'done']);
    }


    public  function show($id)
    {
        $file_name = Attachments::find($id)->url;
        if (Str::startsWith($file_name, 'http://futurecompany.edhub.sd/'))
            $file_name = Str::replaceFirst('http://futurecompany.edhub.sd/',  '', $file_name);
        return response()->file(public_path($file_name));
    }

    public function download($id)
    {
        $file_name = Attachments::find($id)->url;
        if (Str::startsWith($file_name, 'http://futurecompany.edhub.sd/'))
            $file_name = Str::replaceFirst('http://futurecompany.edhub.sd/',  '', $file_name);
        $pathToFile = public_path($file_name);
        return response()->download($pathToFile);
    }
}