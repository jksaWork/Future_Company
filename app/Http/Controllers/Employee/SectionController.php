<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\section;
use App\Http\Requests\sectionRequest;
use Illuminate\Http\Request;
use Exception;

class SectionController extends Controller
{

    public function index(Request $request)
    {
        // return $request;
        $section = section::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('section_name', '%' . $request->search . '%');

        })->latest()->paginate(5);

        return view('admin.Employee.section.index', compact('section'));

    }//end of index


    public function create()
    {
        return view('admin.Employee.section.create');

    }//end of create


    public function store(sectionRequest $request)
    {
        // return  $request;
        try{
            section::create($request->all());
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('Employee.section.index');
    }catch(Exception $e){
        //dd($e);
        session()->flash('error' ,  'Some Thing Went Worng ');
        return redirect()->back();
    }

    }//end of store


    public function show(Section $section)
    {
        //
    }


    public function edit(Request $request ,$id)
    {
        $sections = section::find($id);
        return view('admin.Employee.section.edit', compact('sections'));

    }//end of edit

    public function update(sectionRequest $request, section $section)
    {
    // return $section;
        try{
        $section->update($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('Employee.section.index');

    }catch(Exception $e){
        //dd($e);
        session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }

    }//end of update

    public function destroy(section $section)
    {
        // return $section;
        $section->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('Employee.section.index');

    }//end of destroy

}//end of controller
