<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\school_types;
use App\Models\school_categories;
use App\Http\Requests\CategoiresRequest;
use Illuminate\Http\Request;
use Exception;

class School_CategoiresController extends Controller
{

    public function index(Request $request)
    {
        $school_id =school_types::all();

        return view('admin.School_teachers.School_categories.index',compact('school_id'));

    }//end of index


    public function create()
    {
        $school_id =school_types::all();
        return view('admin.School_teachers.School_categories.create', compact('school_id'));

    }//end of create


    public function store(Request $request)
    {
        // return  $request;
        $request->validate([
            'school_id' =>'required',
            'categories_name' =>'required',
        ]);
        try{
        school_categories::create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('School.categories.index');
    }catch(Exception $e){
        dd($e);
        session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }

    }//end of store


    public function show($id)
    {
        //
    }


    public function edit(Request $request ,$id)
    {
        $school_id =school_types::all();
        $categorys = school_categories::find($id);
        return view('admin.School_teachers.School_categories.edit', compact('categorys','school_id'));

    }//end of edit

    public function update(Request $request ,$id)
    {
        // return $id;
        $request->validate([
            'school_id' =>'required',
            'categories_name' =>'required',
        ]);

        //    return $id;
        $school_categories = school_categories::findOrFail($id);
        try{
        $school_categories->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('School.categories.index');

    }catch(Exception $e){
        // dd($e);
        session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }

    }//end of update

    public function destroy( $id)
    {
        // return $category;
        // $category->delete();
        session()->flash('error', __('site.has_been_transferred_successfully'));
        return redirect()->route('School.categories.index');

    }//end of destroy

}//end of controller
