<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\CategoiresRequest;
use Illuminate\Http\Request;
use Exception;

class CategoiresController extends Controller
{

    public function index(Request $request)
    {
        // return $request;
        $categories = Category::when($request->search, function ($q) use ($request) {

            return $q->whereTranslationLike('categories_name', '%' . $request->search . '%');

        })->latest()->paginate(5);

        return view('admin.Employee.categories.index', compact('categories'));

    }//end of index


    public function create()
    {
        return view('admin.Employee.categories.create');

    }//end of create


    public function store(CategoiresRequest $request)
    {
        // return  $request;
        try{
        Category::create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('Employee.categories.index');
    }catch(Exception $e){
        dd($e);
        session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }

    }//end of store


    public function show(category $category)
    {
        //
    }


    public function edit(Request $request ,$id)
    {
        // return $id;
        $categorys = Category::find($id);
        return view('admin.Employee.categories.edit', compact('categorys'));

    }//end of edit

    public function update(CategoiresRequest $request, Category $category)
    {
        try{
        $category->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('Employee.categories.index');

    }catch(Exception $e){
        // dd($e);
        session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }

    }//end of update

    public function destroy(Category $category)
    {
        // return $category;
        $category->delete();
        session()->flash('error', __('site.has_been_transferred_successfully'));
        return redirect()->route('Employee.categories.index');

    }//end of destroy

}//end of controller
