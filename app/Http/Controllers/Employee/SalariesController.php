<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\salaries;
use App\Models\employee;
use App\Models\Advances;
use App\Models\employee_allowances;
use App\Models\allowances;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\EmployeeRequest;
use App\Models\FinancialTreasuryTransactionHistorys;
use Illuminate\Http\Request;
use Exception;
use PhpParser\Node\Stmt\Foreach_;

class SalariesController extends Controller
{

    public function index(Request $request)
    {
        $salaries = salaries::all();
        return view('admin.Employee.salaries.index', compact('salaries'));
    } //end of index


    public function create(Request $request)
    {
        $employees = employee::where('status', 1)->get();
        // return $employees;
        return view('admin.Employee.salaries.create', compact('employees'));
    } //end of create


    public function store(Request $request)
    {

        // return $request;
        $request->validate([
            'employee_id' => 'required',
            'fixed_salary' => 'required|numeric',
            'advances' => 'required|numeric',
            'totle_salaries' => 'required|numeric',
            'discounts' => 'required|numeric',
            'allowancess_fixed' => 'required|numeric',
        ]);
        DB::beginTransaction();

        try {
            if ($request->totle_salaries > 0) {
               
           
            $DATA = salaries::create([
                'employee_id' => $request->employee_id,
                'fixed_salary' => $request->fixed_salary,
                'allowancess_fixed' => $request->allowancess_fixed,
                'year' => $request->year,
                'advances' => $request->advances,
                'totle_salaries' => $request->totle_salaries,
                'discounts' => $request->discounts,
                'month_number' => $request->month_number,
                'status' => 1,
                'discrption' => $request->discrption,
            ]);
            //    return  $DATA;
            $salaries = salaries::findOrFail($DATA->id);
            $res = FinancialTreasuryTransactionHistorys::MakeTransacaion($salaries->totle_salaries, 'salries', $salaries->employee->name . '-' . __('translation.add_salaries'), $salaries->id);

            $salaries->update([
                'Transaction_id' => $res->id,
            ]);
            DB::commit();
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('Employee.salaries.index');
        }else{
            DB::commit();
            session()->flash('error', __('site.The_total_salary_value_is_less_than_zero'));
            return redirect()->route('Employee.salaries.index');
        }
        } catch (Exception $e) {
            if ($e->getCode() == 51) {
                DB::commit();
                session()->flash('success', __('site.added_successfully'));
                return redirect()->back()->withErrors(__('translation.' . $e->getMessage()))->withInput();
                // if ($e->getCode() == 50)   session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
            }
            DB::commit();  
            if ($e->getCode() == 50) {
                session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
                return redirect()->back();
            }
            DB::rollBack();
            session()->flash('error',  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }
    } //end of store


    public function show($id)
    {

        $employees = employee::findorfail($id);
        return view('admin.Employee.salaries.create', compact('employees'));
    }


    public function edit($id)
    {

        $salaries = salaries::find($id);
        return view('admin.Employee.salaries.edit', compact('salaries'));
    } //end of edit

    public function update(Request $request,  $id)
    {
        $request->validate([
            'employee_id' => 'required',
            'fixed_salary' => 'required|numeric',
            'allowancess_fixed' => 'required|numeric',
            'advances' => 'required|numeric',
            'totle_salaries' => 'required|numeric',
            'discounts' => 'required|numeric',
        ]);
        DB::beginTransaction();
        try {
            $salaries = salaries::findOrFail($id);

            $salaries->update([
                'employee_id' => $request->employee_id,
                'fixed_salary' => $request->fixed_salary,
                'allowancess_fixed' => $request->allowancess_fixed,
                'advances' => $request->advances,
                'totle_salaries' => $request->totle_salaries,
                'discounts' => $request->discounts,
                'discrption' => $request->discrption,
            ]);
            $res = FinancialTreasuryTransactionHistorys::EditTransaction($salaries->Transaction_id, $request->totle_salaries);
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('Employee.salaries.index');
        } catch (Exception $e) {
            if ($e->getCode() == 51) {
                DB::commit();
                session()->flash('success', __('site.updated_successfully'));
                return redirect()->back()->withErrors(__('translation.' . $e->getMessage()))->withInput();
                // if ($e->getCode() == 50)   session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
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

    public function destroy($id)
    {
        // return $id;
        $salaries = salaries::findOrFail($id);
        $salaries->delete();
        session()->flash('error', __('site.has_been_transferred_successfully'));
        return redirect()->route('Employee.salaries.index');
    } //end of destroy


    public function EmployeeSalaries(Request $request)
    {

        $request->validate([
            'employee_id' => 'required',
            'month_number' => 'required|numeric',
            'year' => 'required|numeric',
        ]);

        $m = $request->employee_id;
        $q = $request->month_number;
        $y = $request->year;

        $s  = salaries::where([
            ['employee_id', $m],
            ['month_number', $q],
            ['year', $y]
        ])->get();
        // return $s->count();
        $r = $s->count();

        if ($r === 0) {
            $allowances = employee_allowances::where([
            ['status', 1],
            ['employee_id', $m]
            ])->get();
            $employees = employee::findorfail($m);
            $employee_advances  = advances::where([['employee_id', $m], ['month_number', $q], ['year', $y]])->get();
            return view('admin.Employee.salaries.salaries_show', compact('employee_advances', 'employees', 'q', 'y', 'allowances'));
        } else {
            session()->flash('error',  __('site.Salary_has_already_been_submitted'));
            return redirect()->back();
        }
    }
    public function print_salaries(Request $request, $id)
    {
        // dd('ok');
        $salaries = salaries::findOrFail($id);
        return view('admin.Employee.salaries.print', compact('salaries'));
    }
}//end of controller