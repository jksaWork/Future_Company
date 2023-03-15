<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\school_sections;
use App\Models\school_types;
use App\Http\Requests\sectionRequest;
use Illuminate\Http\Request;
use Exception;

class School_SectionController extends Controller
{

    public function index(Request $request)
    {
        

        return view('admin.School_teachers.School_section.index');

    }//end of index


    public function create()
    {
        // return 1;
        $school_id =school_types::all();
        return view('admin.School_teachers.School_section.create' , compact('school_id'));

    }//end of create


    public function store(Request $request)
    {
        $request->validate([
            'school_id' =>'required',
            'section_name' =>'required',
        ]);
        // return  $request;
        try{
            school_sections::create($request->all());
            session()->flash('success', __('site.added_successfully'));
        return redirect()->route('School.section.index');
    }catch(Exception $e){
        dd($e);
            session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }

    }//end of store


    public function show(Request $request)
    {
        //
    }


    public function edit(Request $request ,$id)
    {
        $school_id =school_types::all();
        $school_sections = school_sections::find($id);
        return view('admin.School_teachers.School_section.edit', compact('school_sections','school_id'));

    }//end of edit

    public function update(Request $request ,  $id)
    {
        // return $request;
        $request->validate([
            'school_id' =>'required',
            'section_name' =>'required',
        ]);

        //    return $id;
        $school_sections = school_sections::findOrFail($id);
        try{
        $school_sections->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('School.section.index');

    }catch(Exception $e){
        //dd($e);
        session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }

    }//end of update

    public function destroy(Request $request)
    {
        // return $section;
        // $section->delete();
        session()->flash('error', __('site.has_been_transferred_successfully'));
        return redirect()->route('Employee.section.index');

    }//end of destroy

}//end of controller
