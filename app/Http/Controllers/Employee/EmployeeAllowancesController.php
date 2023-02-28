<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\employee_allowances;
use App\Models\allowances;
use App\Models\FinancialTreasuryTransactionHistorys;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Employee_allowancesRequest;
use Illuminate\Http\Request;
use Exception;

class EmployeeAllowancesController extends Controller
{

    public function index(Request $request)
    {
        // return $Categorys;
        // $employee_allowances = employee_allowances::all();
        $employee_allowances =employee_allowances::where([
            ['status',  0],
        ])->get();
        // return $employee_allowances;
        $employee   = employee::all();
        $allowances =allowances::where([
            ['status',  0],
        ])->get();
        // $allowances = allowances::all();

        return view('admin.Employee.employee_allowances.index', compact('employee_allowances' ,'employee' ,'allowances'));
    } //end of index


    public function create(Employee $employee)
    {
        $employees =employee::where([
            ['status',  1],
        ])->get();
        $allowances =allowances::where([
            ['status',  0],
        ])->get();
        // return $allowances;
        return view('admin.Employee.employee_allowances.create', compact('employees','allowances'));

        // return view('admin.Employee.employee_allowances.create');
    } //end of create


    public function store(employee_allowancesRequest $request)
    {
        // return  $request;
        DB::beginTransaction();
        try {
           $employee_allow = employee_allowances::create([
                'employee_id'   => $request->employee_id,
                'allowances_id' => $request->allowances_id,
                'status' => 0,
                'month_number' => $request->month_number,
            ]);
            $employ_allow = employee_allowances::findOrFail($employee_allow->id);
            //    return  $spendingses->spending_value;
            $res = FinancialTreasuryTransactionHistorys::MakeTransacaion($employee_allow->Allowances_id->allowances_value , 'incentives', $employee_allow->employee->name . '-'.$employee_allow->Allowances_id->allowances_name , $employee_allow->id);

            $employ_allow->update([
                'Transaction_id' => $res->id,
            ]);
            DB::commit();
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('Employee.employee_allowances.index');
        } catch (Exception $e) {
            DB::rollBack();
            if($e->getCode() == 50)   session()->flash('error' ,  __('site.There_is_no_amount_available_in_the_safe'));
            return redirect()->back();
        }
    } //end of store


    public function show($id)
    {
        $allowances =allowances::where([
            ['status',  0],
        ])->get();
        // $allowances =allowances::all();
        $employees = employee::findorfail($id);
        // return $employees;
        return view('admin.Employee.employee_allowances.create',compact('employees' , 'allowances'));
    }


    public function edit(employee $employee, $id)
    {
        // return $id;
        $employees = employee::wheare('status', 1);
        $allowances =allowances::where([
            ['status',  0],
        ])->get();
        // $allowances =allowances::all();
        $employee_allowances = employee_allowances::findorfail($id);

        return view('admin.Employee.employee_allowances.edit', compact('allowances', 'employee_allowances','employees'));
    } //end of edit

    public function update(employee_allowancesRequest $request,$id)
    {
        // return $request;
        DB::beginTransaction();
        try{

        // $id = allowances::where('categories_name', $request->categories_id)->first()->id;
        //    return $id;
        $employee = employee_allowances::findOrFail($id);
// return  $employee->Transaction_id  ;
        $employee->update([

            'employee_id'   => $request->employee_id,
            'allowances_id' => $request->allowances_id,
            'status' => 0,
            'month_number' => $request->month_number,
        ]);

        $res = FinancialTreasuryTransactionHistorys::EditTransaction( $employee->Transaction_id , $employee->Allowances_id->allowances_value );
// return $res;
        DB::commit();
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('Employee.employee_allowances.index');
        }catch(Exception $e){
           dd($e);
            DB::rollBack();
            if($e->getCode() == 50)   session()->flash('error' ,  __('site.There_is_no_amount_available_in_the_safe'));
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
