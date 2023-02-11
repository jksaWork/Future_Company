<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\Category;

use App\Http\Requests\EmployeeRequest;
use Illuminate\Http\Request;
use Exception;

class AllEmployeeController extends Controller
{

    public function index(Request $request)
    {
        // return $request;
        $Categorys = Category::all();
        // return $Categorys;
        $employees = employee::all();

        return view('admin.Employee.All_Employee.index', compact('employees','Categorys'));

    }//end of index


    public function create()
    {
        $Category = Category::all();
        return view('admin.Employee.All_Employee.create', compact('Category'));

    }//end of create


    public function store(EmployeeRequest $request)
    {
        // return  $request;

        try{
           $DATA= employee::create([
            'name' => $request->name,
           'email' => $request->email,
           'description' => $request->description,
           'phone' => $request->phone,
           'address' => $request->address,
           'salary' => $request->description,
           'categories_id' => $request->categories_id,
           'status' => $request->status,
           'description' => $request->description,
        ]);
        //    return  $DATA;
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('Employee.All_Employee.index');
    }catch(Exception $e){
        // dd($e);
        session()->flash('error' ,  'Some Thing Went Worng ');
        return redirect()->back();
    }

    }//end of store


    public function show(employee $employee)
    {
        //
    }


    public function edit(employee $employee)
    { $Categorys = Category::all();
        // return $Categorys;
        $employees = employee::all();
        return view('admin.Employee.All_Employee.edit', compact('category','employees'));

    }//end of edit

    public function update(Request $request, employee $employee)
    {
        try{
        $employee->update($request->all());
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('Employee.All_Employee.index');

    }catch(Exception $e){
        dd($e);
        session()->flash('error' ,  'Some Thing Went Worng ');
        return redirect()->back();
    }

    }//end of update

    public function destroy(employee $employee)
    {
        // return $employee;
        $employee->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('Employee.All_Employee.index');

    }//end of destroy

}//end of controller
