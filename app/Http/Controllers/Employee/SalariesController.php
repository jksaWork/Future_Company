<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\Category;
use App\Models\Image;

use App\Http\Requests\EmployeeRequest;
use Illuminate\Http\Request;
use Exception;

class SalariesController extends Controller
{

    public function index(Request $request)
    {
        // return $request;
        $Categorys = Category::all();
        // return $Categorys;
        $employees = employee::all();

        return view('admin.Employee.salaries.index', compact('employees', 'Categorys'));
    } //end of index


    public function create()
    {
        $Category = Category::all();
        return view('admin.Employee.salaries.create', compact('Category'));
    } //end of create


    public function store(EmployeeRequest $request)
    {
        // return  $request;

        try {
            $DATA = employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'description' => $request->description,
                'phone' => $request->phone,
                'address' => $request->address,
                'salary' => $request->salary,
                'categories_id' => $request->categories_id,
                'status' => $request->status,
                'description' => $request->description,
            ]);
            //    return  $DATA;
            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route('Employee.salaries.index');
        } catch (Exception $e) {
            // dd($e);
            session()->flash('error',  'Some Thing Went Worng ');
            return redirect()->back();
        }
    } //end of store


    public function show($id)
    {
        // return $id;
        $Category = Category::all();
        $employees = employee::findorfail($id);
        return view('admin.Employee.salaries.create',compact('employees','Category'));
    }


    public function edit(employee $employee, $id)
    {
        $Categorys = Category::all();
        // return $Categorys;
        $employees = employee::find($id);
        return view('admin.Employee.salaries.edit', compact('Categorys', 'employees'));
    } //end of edit

    public function update(EmployeeRequest $request, Employee $employee)
    {
        // return $request;
        try{

        $id = Category::where('categories_name', $request->categories_id)->first()->id;
        //    return $id;
        $employee = employee::findOrFail($request->pro_id);

        $employee->update([
            'name' => $request->name,
                'email' => $request->email,
                'description' => $request->description,
                'phone' => $request->phone,
                'address' => $request->address,
                'salary' => $request->salary,
                'categories_id' => $id,
                'status' => $request->status,
                'description' => $request->description,
        ]);
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('Employee.salaries.index');
        }catch(Exception $e){
            dd($e);
            session()->flash('error' ,  'Some Thing Went Worng ');
            return redirect()->back();
        }

    } //end of update

    public function destroy( Employee $employee , $id)
    {
        // return $id;
        $employee = employee::findOrFail($id);
        $employee->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('Employee.salaries.index');
    } //end of destroy



}//end of controller
