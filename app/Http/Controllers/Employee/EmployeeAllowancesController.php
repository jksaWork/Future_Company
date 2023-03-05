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


    public function store(Request $request)
    {
        $request->validate([
            'allowances_id' =>'required',
            'employee_id' => 'required',
            'month_number'=>'required',
            'year'=>'required',
        ]);


        DB::beginTransaction();
        try {
           $employee_allow = employee_allowances::create([
                'employee_id'   => $request->employee_id,
                'allowances_id' => $request->allowances_id,
                'year'=> $request->year,
                'status' => 0,
                'month_number' => $request->month_number,
            ]);
            $employee_allow = employee_allowances::findOrFail($employee_allow->id);
            //    return  $spendingses->spending_value;
            
            $res = FinancialTreasuryTransactionHistorys::MakeTransacaion($employee_allow->Allowances_id->allowances_value , 'incentives', $employee_allow->employee->name . '-'.$employee_allow->Allowances_id->allowances_name , $employee_allow->id);
            
           $d= $employee_allow->update([
                'Transaction_id' => $res->id,
            ]);
            
            DB::commit();
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('Employee.employee_allowances.index');
        } catch (Exception $e) {
            dd($e);
            // if ($e->getCode() == 51) {
            //     DB::commit();
            //     session()->flash('success', __('site.added_successfully'));
            //     return redirect()->back()->withErrors(__('translation.' . $e->getMessage()))->withInput();
            //     // if ($e->getCode() == 50)   session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
            // }
            DB::rollBack();
            if ($e->getCode() == 50) {
                session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
                return redirect()->back();
            }
            session()->flash('error',  __('site.Some_Thing_Went_Worng'));
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
        $employees = employee::where([['status', 1],])->get();
    
        $allowances =allowances::where([
            ['status',  0],
        ])->get();
        // $allowances =allowances::all();
        $employee_allowances = employee_allowances::findorfail($id);

        return view('admin.Employee.employee_allowances.edit', compact('allowances', 'employee_allowances','employees'));
    } //end of edit

    public function update(Request $request,$id)
    {
        $request->validate([
            'allowances_id' =>'required',
            'employee_id' => 'required',
            'month_number'=>'required',
            'year'=>'required',
        ]);



        DB::beginTransaction();
        try{

        $employee = employee_allowances::findOrFail($id);
        $employee->update([

            'employee_id'   => $request->employee_id,
            'allowances_id' => $request->allowances_id,
            'year'=> $request->year,
            'status' => 0,
            'month_number' => $request->month_number,
        ]);
        $res = FinancialTreasuryTransactionHistorys::EditTransaction( $employee->Transaction_id , $employee->Allowances_id->allowances_value );

        DB::commit();
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('Employee.employee_allowances.index');
        }catch(Exception $e){
            // dd($e);
            if ($e->getCode() == 51) {
                DB::commit();
                session()->flash('success', __('site.updated_successfully'));
                return redirect()->back()->withErrors(__('translation.' . $e->getMessage()))->withInput();
            }
            DB::rollBack();
            if ($e->getCode() == 50) {
                session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
                return redirect()->back();
            }
            session()->flash('error',  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }

    } //end of update

    public function destroy( Employee $employee , $id)
    {
        // return $id;
        $employemployee_allowancesee = employee_allowances::findOrFail($id);  
        // return $employemployee_allowancesee->Transaction_id;
        $res = FinancialTreasuryTransactionHistorys::DestoryTransaction( $employemployee_allowancesee->Transaction_id);
 
        $employemployee_allowancesee->delete();
        session()->flash('error', __('site.has_been_transferred_successfully'));
        return redirect()->route('Employee.employee_allowances.index');
    } //end of destroy



}//end of controller
