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
use Illuminate\Http\Request;
use Exception;

class SalariesController extends Controller
{

    public function index(Request $request)
    {
        $month = $request->month;
        $employee_id = $request->employee_id;
        $end_month = $request->end_month;

        // being sreach date and id employee employee allowances
        $employee_allowancess = employee_allowances::where('employee_id', $employee_id)->whereBetween('month', [$month, Carbon::parse($end_month)->endOfDay(),])->get();
        // end employee allowances
        // being sreach date and id employee employee advances
        $employee_advances = advances::where('employee_id', $employee_id)->whereBetween('advances_Date', [$month, Carbon::parse($end_month)->endOfDay(),])->get();
       // end employee advances;
        // return $employee_advances;
        $employees = employee::findorfail($employee_id);
        return view('admin.Employee.salaries.salaries_show', compact('employees','employee_advances','employee_allowancess'));
    } //end of index


    public function create(Request $request)
    {
        $salaries = salaries::all();
        return view('admin.Employee.salaries.index', compact('salaries'));
    } //end of create


    public function store(Request $request)
    {
        // return $request;
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
                'discrption' => $request->discrption,
            ]);
            //    return  $DATA;
            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route('Employee.salaries.create');
        } catch (Exception $e) {
            dd($e);
            session()->flash('error',  'Some Thing Went Worng ');
            return redirect()->back();
        }
    } //end of store


    public function show($id)
    {

        $employees = employee::findorfail($id);
        return view('admin.Employee.salaries.create', compact('employees'));
    }


    public function edit( $id)
    {

        $salaries = salaries::find($id);
        return view('admin.Employee.salaries.edit', compact('salaries'));
    } //end of edit

    public function update(Request $request,  $id)
    {
        // return $request;
        try {
            $salaries = salaries::findOrFail($id);

            $salaries->update([
                'employee_id' => $request->employee_id,
                'fixed_salary' => $request->fixed_salary,
                'allownacees_salary' => $request->allownacees_salary,
                'advances' => $request->advances,
                'totle_salaries' => $request->totle_salaries,
                'discounts' => $request->discounts,
                'month' => $request->month,
                'status' => $request->status,
                'discrption' => $request->discrption,
            ]);
            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route('Employee.salaries.create');
        } catch (Exception $e) {
            dd($e);
            session()->flash('error',  'Some Thing Went Worng ');
            return redirect()->back();
        }
    } //end of update

    public function destroy( $id)
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
        return view('admin.Employee.salaries.salaries_show', compact('employees','employee_advances','employee_allowancess'));

    } //end of salaries_show




}//end of controller
