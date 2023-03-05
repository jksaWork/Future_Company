<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\Advances;
use App\Models\FinancialTreasuryTransactionHistorys;
use Illuminate\Support\Facades\DB;
// use App\Http\Requests\Request;
use Illuminate\Http\Request;
use Exception;

class AdvancesController extends Controller
{

    public function index(Request $request)
    {

        $Advances = Advances::all();

        return view('admin.Employee.Advances.index', compact('Advances'));
    } //end of index


    public function create()
    {
        $employees = employee::where([['status', 1],])->get();
        return view('admin.Employee.Advances.create', compact('employees'));
    } //end of create


    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'employee_id' => 'required',
            'advances_value' => 'required|numeric',
            'month_number' => 'required|numeric',
            'year' => 'required|numeric',
        ]);
        DB::beginTransaction();
        try {
            $employee_advances  = advances::where([['employee_id', $request->employee_id], ['month_number', $request->month_number], ['year', $request->year]])->get();

            $sum_advances_value = 0;
            foreach ($employee_advances as $index => $Advancess) {
                $sum_advances_value += $Advancess->advances_value;
            }
            $sum = $sum_advances_value + $request->advances_value;
            $employee = employee::find($request->employee_id);
            $sum_employee = $employee->salary;

            if ($sum  < $sum_employee) {
                $advance = Advances::create([
                    'employee_id' => $request->employee_id,
                    'year' => $request->year,
                    'advances_value' => $request->advances_value,
                    'month_number' => $request->month_number,
                ]);

                $advances = Advances::findOrFail($advance->id);
                   return  $advances->employee->name;
                $res = FinancialTreasuryTransactionHistorys::MakeTransacaion( $advances->advances_value, 'advance', $advances->employee->name .'-'.__('translation.Add_Advances') , $advances->id);

                $advances->update([
                    'Transaction_id' => $res->id,
                ]);
                DB::commit();
                session()->flash('success', __('site.added_successfully'));
                return redirect()->route('Employee.Advances.index');
            } else {
                session()->flash('error',  __('site.You_have_exceeded_the_salary_imit'));
                return redirect()->back();
            }
        } catch (Exception $e) {
dd($e);
            if ($e->getCode() == 51) {
                DB::commit();
                session()->flash('success', __('site.added_successfully'));
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
    } //end of store


    public function show($id)
    {

        $employees = employee::findorfail($id);
        // return $employees;
        return view('admin.Employee.Advances.create', compact('employees'));
    }


    public function edit(Request $request, $id)
    {
        // return $id;
        $employees = employee::where([['status', 1],])->get();
        $Advancess = Advances::find($id);
        return view('admin.Employee.Advances.edit', compact('Advancess', 'employees'));
    } //end of edit

    public function update(Request $request,  $id)
    {
        $request->validate([
            'employee_id' => 'required',
            'advances_value' => 'required|numeric',
            'month_number' => 'required|numeric',
            'year' => 'required|numeric',
        ]);
        DB::beginTransaction();
        try {
            $employee_advances  = advances::where([['employee_id', $request->employee_id], ['month_number', $request->month_number], ['year', $request->year]])->get();

            $sum_advances_value = 0;
            foreach ($employee_advances as $index => $Advancess) {
                $sum_advances_value += $Advancess->advances_value;
            }
            $sum = $sum_advances_value + $request->advances_value;
            $employee = employee::find($request->employee_id);
            $sum_employee = $employee->salary;

            if ($sum  < $sum_employee) {
            $Advancess = Advances::findOrFail($id);

            $Advancess->update([
                'employee_id' => $request->employee_id,
                'advances_value' => $request->advances_value,
                'year' => $request->year,
                'month_number' => $request->month_number,
            ]);
            // return  $Advancess->advances_value;
            $res = FinancialTreasuryTransactionHistorys::EditTransaction($Advancess->Transaction_id, $Advancess->advances_value);

            DB::commit();
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('Employee.Advances.index');
        } else {
            session()->flash('error',  __('site.You_have_exceeded_the_salary_imit'));
            return redirect()->back();
        }
        } catch (Exception $e) {
            dd($e);
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

    public function destroy(Request $request, $id)
    {
        // return $id;
        $Advances = Advances::findOrFail($id);
        $Advances->delete();
        session()->flash('error', __('site.has_been_transferred_successfully'));
        return redirect()->route('Employee.Advances.index');
    } //end of destroy



}//end of controller
