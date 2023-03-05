<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\salaries;
use App\Models\employee_allowances;
use App\Models\allowances;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\EmployeeRequest;
use Illuminate\Http\Request;
use Exception;
use PhpParser\Node\Stmt\Echo_;

class EmployeeSalariesController extends Controller
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
            $DATA = salaries::create([
                'employee_id' => $request->employee_id,
                'fixed_salary' => $request->fixed_salary,
                'allownacees_salary' => $request->allownacees_salary,
                'advances' => $request->advances,
                'totle_salaries' => $request->totle_salaries,
                'discounts' => $request->discounts,
                'month' => $request->month,
                'status' => $request->status,
                'description' => $request->description,
            ]);
            //    return  $DATA;
        session()->flash('success', __('site.added_successfully'));
            return redirect()->route('Employee.salaries.index');
        } catch (Exception $e) {
            // //dd($e);
        session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
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
            'month' => $request->month,
        ]);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('Employee.employee_allowances.index');
        }catch(Exception $e){
            //dd($e);
            session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }

    } //end of update

    public function destroy( Employee $employee , $id)
    {
        // return $id;
        $employemployee_allowancesee = employee_allowances::findOrFail($id);
        $employemployee_allowancesee->delete();
        session()->flash('success', __('site.has_been_transferred_successfully'));
        return redirect()->route('Employee.employee_allowances.index');
    } //end of destroy

public function data(){
// echo 'hhjhkh';
    $query = salaries::with('employee');
    return  DataTables::of($query)
        ->editColumn('created_at', function ($item) {
            return $item->created_at->format('Y-m-d');
        })
        ->editColumn('status', function ($item) {
            return  $item->getStatusWithSpan();
        })
        // ->editColumn('is_sale', fn ($item) => $item->getSaleStatusWithSpan('is_sale', 'saled'))
        // ->editColumn('is_rent', fn ($item) => $item->getSaleStatusWithSpan('is_rent', 'rented'))
        ->editColumn('employee_id', fn ($item) => $item->employee->name ?? '')
        ->editColumn(
            'actions',
            'admin.realstate.data_table.actions'
        )
        ->rawColumns(['actions', 'status', 'is_rent', 'is_sale'])
        ->toJson();
}

}//end of controller
