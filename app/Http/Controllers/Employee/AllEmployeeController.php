<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\Category;
use App\Models\Image;
use App\Models\employee_allowances;
use App\Models\Advances;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Http\Request;
use Exception;

class AllEmployeeController extends Controller
{

    public function index(Request $request)
    {
        $Categorys = Category::all();
        $employees = employee::all();

        return view('admin.Employee.All_Employee.index', compact('employees', 'Categorys'));
    } //end of index


    public function create()
    {
        $Category = Category::all();
        return view('admin.Employee.All_Employee.create', compact('Category'));
    } //end of create


    public function store(EmployeeRequest $request)
    {

        try {
            employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'salary' => $request->salary,
                'categories_id' => $request->categories_id,
                'status' => $request->status,
                'description' => $request->description,
            ]);
            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route('Employee.All_Employee.index');
        } catch (Exception $e) {
            // dd($e);
            session()->flash('error',  'Some Thing Went Worng ');
            return redirect()->back();
        }
    } //end of store


    public function show($id)
    {
        // return $id;
        $images = Image::all();
        // return $images;

            $allowances_id = employee_allowances::where( 'employee_id' ,[$id])->get();
            // return $allowances_id;
            $Advances_id = Advances::where( 'employee_id' ,[$id])->get();
            // return $Advances_id;
        $employees = employee::findorfail($id);
        return view('admin.Employee.All_Employee.show',compact('employees','images','Advances_id','allowances_id'));
    }


    public function edit(employee $employee, $id)
    {
        $Categorys = Category::all();
        // return $Categorys;
        $employees = employee::find($id);
        return view('admin.Employee.All_Employee.edit', compact('Categorys', 'employees'));
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
        return redirect()->route('Employee.All_Employee.index');
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
        return redirect()->route('Employee.All_Employee.index');
    } //end of destroy



}//end of controller