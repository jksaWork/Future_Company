<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\salaries;
use App\Models\employee;
use App\Models\advances;
use App\Models\employee_allowances;
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
            $month_number = $request->month_number;
            $employee_id = $request->employee_id;
        $employee_allowancess = employee_allowances::where([['employee_id', $employee_id],
        ['month_number', $month_number],
        ['status', 0],
        ])->get();

<<<<<<< HEAD
         $allowancess_fixed = employee_allowances::where([['employee_id', $employee_id],
        ['status', 1],
        ])->get();

        $employee_advances = advances::where([['employee_id', $employee_id],
        ['month_number', $month_number],
        ])->get();
        $allowancess_sum = 0;
        foreach($allowancess_fixed as  $q){
            $allowancess_sum += $q->Allowances_id->allowances_value;
        }
        // return $allowancess_sum;
        $employees = employee::findorfail($employee_id);
        return view('admin.Employee.salaries.salaries_show', compact('employees','employee_advances','employee_allowancess','allowancess_sum'));
=======
        // being sreach date and id employee employee allowances
        $employee_allowancess = employee_allowances::where('employee_id', $employee_id)->whereBetween('month', [$month, Carbon::parse($end_month)->endOfDay(),])->get();
        // end employee allowances
        // being sreach date and id employee employee advances
        $employee_advances = advances::where('employee_id', $employee_id)->whereBetween('advances_Date', [$month, Carbon::parse($end_month)->endOfDay(),])->get();
        // end employee advances;
        // return $employee_advances;
        $employees = employee::findorfail($employee_id);
        return view('admin.Employee.salaries.salaries_show', compact('employees', 'employee_advances', 'employee_allowancess'));
>>>>>>> c25ff6551f0d2ac202169e82e6399e841c9931a3
    } //end of index


    public function create(Request $request)
    {
        $salaries = salaries::all();
        return view('admin.Employee.salaries.index', compact('salaries'));
    } //end of create


    public function store(Request $request)
    {

        // return $request;
        $request->validate([
            'employee_id' => 'required',
            'fixed_salary' => 'required|numeric',
            'allownacees_salary' => 'required|numeric',
            'advances' => 'required|numeric',
            'totle_salaries' => 'required|numeric',
            'discounts' => 'required|numeric',
            'month_number' => 'required|numeric',
            'allowancess_fixed' => 'required|numeric',
            'status' => 'required',
        ]);


        try {
<<<<<<< HEAD
            // return $request;
=======
            $employee =  employee::findOrFail($request->employee_id);
>>>>>>> c25ff6551f0d2ac202169e82e6399e841c9931a3
            $DATA = salaries::create([
                'employee_id' => $request->employee_id,
                'fixed_salary' => $request->fixed_salary,
                'allowancess_fixed'=> $request->allowancess_fixed,
                'allownacees_salary' => $request->allownacees_salary,
                'advances' => $request->advances,
                'totle_salaries' => $request->totle_salaries,
                'discounts' => $request->discounts,
                'month_number' => $request->month_number,
                'status' => $request->status,
                'discrption' => $request->discrption,
            ]);
            //    return  $DATA;
<<<<<<< HEAD
            session()->flash('success', __('site.added_successfully'));
=======
            FinancialTreasuryTransactionHistorys::MakeTransacaion($request->Installment->totle_salaries, 'salries',  __('translation.employee_salary') . ' - ' . $employee->name, $DATA->id);

            session()->flash('success', __('site.deleted_successfully'));
>>>>>>> c25ff6551f0d2ac202169e82e6399e841c9931a3
            return redirect()->route('Employee.salaries.create');
        } catch (Exception $e) {
            dd($e);
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
            'allownacees_salary' => 'required|numeric',
            'advances' => 'required|numeric',
            'totle_salaries' => 'required|numeric',
            'discounts' => 'required|numeric',
            'month_number' => 'required|numeric',
            'status' => 'required',
        ]);
        try {
            $salaries = salaries::findOrFail($id);

            $salaries->update([
                'employee_id' => $request->employee_id,
                'fixed_salary' => $request->fixed_salary,
                'allowancess_fixed' => $request->allowancess_fixed,
                'allownacees_salary' => $request->allownacees_salary,
                'advances' => $request->advances,
                'totle_salaries' => $request->totle_salaries,
                'discounts' => $request->discounts,
                'month_number' => $request->month_number,
                'status' => $request->status,
                'discrption' => $request->discrption,
            ]);
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('Employee.salaries.create');
        } catch (Exception $e) {
            //dd($e);
            session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }
    } //end of update

    public function destroy($id)
    {
        // return $id;
        $salaries = salaries::findOrFail($id);
        $salaries->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('Employee.salaries.create');
    } //end of destroy


    public function salaries_show(Request $request)
    {
        $month = $request->month;
        $employee_id = $request->employee_id;
        $end_month = $request->end_month;

        // being sreach date and id employee employee allowances
        $employee_allowances = employee_allowances::whereBetween('month', [$month, Carbon::parse($end_month)->endOfDay(),])->get();
        foreach ($employee_allowances as $list_allowancess) {
            $employee_allowancess = $list_allowancess->where('employee_id', $employee_id)->get();
        }
        // end employee allowances
        // being sreach date and id employee employee advances
        $advances = advances::whereBetween('advances_Date', [$month, Carbon::parse($end_month)->endOfDay(),])->get();
        foreach ($advances as $list_advances) {
            $employee_advances = $list_advances->where('employee_id', $employee_id)->get();
        } // end employee advances;
        $employees = employee::findorfail($employee_id);
        return view('admin.Employee.salaries.salaries_show', compact('employees', 'employee_advances', 'employee_allowancess'));
    } //end of salaries_show




}//end of controller