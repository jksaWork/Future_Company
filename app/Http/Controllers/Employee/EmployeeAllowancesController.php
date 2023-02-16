<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\Category;
use App\Models\employee_allowances;
use App\Models\allowances;

use App\Http\Requests\EmployeeRequest;
use Illuminate\Http\Request;
use Exception;

class EmployeeAllowancesController extends Controller
{

    public function index(Request $request)
    {
        // return $Categorys;
        $employee_allowances = employee_allowances::all();
        // return $employee_allowances;
        $employee   = employee::all();
        $allowances = allowances::all();

        return view('admin.Employee.employee_allowances.index', compact('employee_allowances' ,'employee' ,'allowances'));
    } //end of index


    public function create(Employee $employee)
    {
        $employees = employee::all();
        return view('admin.Employee.employee_allowances.create', compact('employees'));
    } //end of create


    public function store(Request $request)
    {
        // return  $request;

        try {
            employee_allowances::create([
                'employee_id'   => $request->employee_id,
                'allowances_id' => $request->allowances_id,
            ]);
            //    return  $DATA;
            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route('Employee.employee_allowances.index');
        } catch (Exception $e) {
            dd($e);
            session()->flash('error',  'Some Thing Went Worng ');
            return redirect()->back();
        }
    } //end of store


    public function show($id)
    {
        $allowances =allowances::all();
        $employees = employee::findorfail($id);
        // return $employees;
        return view('admin.Employee.employee_allowances.create',compact('employees' , 'allowances'));
    }


    public function edit(employee $employee, $id)
    {
        // return $id;
        $allowances =allowances::all();
        $employee_allowances = employee_allowances::findorfail($id);

        return view('admin.Employee.employee_allowances.edit', compact('allowances', 'employee_allowances'));
    } //end of edit

    public function update(Request $request, Employee $employee)
    {
        // return $request;
        try{

        // $id = allowances::where('categories_name', $request->categories_id)->first()->id;
        //    return $id;
        $employee = employee_allowances::findOrFail($request->pro_id);

        $employee->update([

            'employee_id'   => $request->employee_id,
            'allowances_id' => $request->allowances_id,
        ]);
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('Employee.employee_allowances.index');
        }catch(Exception $e){
            dd($e);
            session()->flash('error' ,  'Some Thing Went Worng ');
            return redirect()->back();
        }

    } //end of update

    public function destroy( Employee $employee , $id)
    {
        // return $id;
        $employemployee_allowancesee = employee_allowances::findOrFail($id);
        $employemployee_allowancesee->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('Employee.employee_allowances.index');
    } //end of destroy



}//end of controller
