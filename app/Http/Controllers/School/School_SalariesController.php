<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\school_salaries;
use App\Models\school_teachers;
use App\Models\school_advances;
use App\Models\school_types;
use App\Models\school_teachers_allowances;
use App\Models\school_allowances;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\EmployeeRequest;
use App\Models\SchoolTreasuryTransactionHistory;
use Illuminate\Http\Request;
use Exception;
use PhpParser\Node\Stmt\Foreach_;

class School_SalariesController extends Controller
{

    public function index(Request $request)
    {
        $school_id =school_types::all();
        return view('admin.School_teachers.School_salaries.index', compact('school_id'));
    } //end of index


    public function create(Request $request)
    {
        $school_id =school_types::all();
        $employees = school_teachers::where('status', 1)->get();
        // return $employees;
        return view('admin.School_teachers.School_salaries.create', compact('employees','school_id'));
    } //end of create


    public function store(Request $request)
    {

        // return $request;
        $request->validate([
            'teachers_id' => 'required',
            'school_id' => 'required',
            'fixed_salary' => 'required|numeric',
            'advances' => 'required|numeric',
            'totle_salaries' => 'required|numeric',
            'discounts' => 'required|numeric',
            'allowancess_fixed' => 'required|numeric',
        ]);
        DB::beginTransaction();

        try {
            if ($request->totle_salaries >= 0) {


                $DATA = school_salaries::create([
                    'teachers_id' => $request->teachers_id,
                    'school_id' => $request->school_id,
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
                $salaries = school_salaries::findOrFail($DATA->id);
                $res = SchoolTreasuryTransactionHistory::MakeTransacaion($salaries->totle_salaries, 'salries', $salaries->teachers->name . '-' . $salaries->teachers->name,$salaries->school_id, $salaries->id);

                $salaries->update([
                    'Transaction_id' => $res->id,
                ]);
                DB::commit();
                session()->flash('success', __('site.added_successfully'));
                return redirect()->route('School.salaries.index');
            } else {
                DB::commit();
                session()->flash('error', __('site.The_total_salary_value_is_less_than_zero'));
                return redirect()->route('School.salaries.index');
            }
        } catch (Exception $e) {
            dd($e);
            // if ($e->getCode() == 51) {
            //     DB::commit();
            //     session()->flash('success', __('site.added_successfully'));
            //     return redirect()->back()->withErrors(__('translation.' . $e->getMessage()))->withInput();
            //     // if ($e->getCode() == 50)   session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
            // }
            // DB::commit();
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

        // $employees = employee::findorfail($id);
        // return view('admin.School_teachers.School_salaries.create', compact('employees'));
    }


    public function edit($id)
    {

        $salaries = school_salaries::find($id);
        return view('admin.School_teachers.School_salaries.edit', compact('salaries'));
    } //end of edit

    public function update(Request $request,  $id)
    {
        // return $request;
        $request->validate([
            'teachers_id' => 'required',
            'school_id' => 'required',
            'fixed_salary' => 'required|numeric',
            'allowancess_fixed' => 'required|numeric',
            'advances' => 'required|numeric',
            'totle_salaries' => 'required|numeric',
            'discounts' => 'required|numeric',
        ]);
        DB::beginTransaction();
        try {
            if ($request->totle_salaries >= 0) {
            $salaries = school_salaries::findOrFail($id);

            $salaries->update([
                'teachers_id' => $request->teachers_id,
                'school_id' => $request->school_id,
                'fixed_salary' => $request->fixed_salary,
                'allowancess_fixed' => $request->allowancess_fixed,
                'advances' => $request->advances,
                'totle_salaries' => $request->totle_salaries,
                'discounts' => $request->discounts,
                'discrption' => $request->discrption,
            ]);
            $res = SchoolTreasuryTransactionHistory::EditTransaction($salaries->Transaction_id, $request->totle_salaries);
            DB::commit();
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('School.salaries.index');
        } else {
            DB::commit();
            session()->flash('error', __('site.The_total_salary_value_is_less_than_zero'));
            return redirect()->route('School.salaries.index');
        }
        } catch (Exception $e) {
            // dd($e);
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
        try {
            $salaries = school_salaries::findOrFail($id);
            $res = SchoolTreasuryTransactionHistory::DestoryTransaction($salaries->Transaction_id);
            // $res = FinancialTreasuryTransactionHistorys::DestoryTransaction($salaries->Transaction_id);
            $salaries->delete();
            session()->flash('error', __('site.has_been_transferred_successfully'));
            return redirect()->route('School.salaries.index');
        } catch (Exception $e) {
            if ($e->getCode() == 51) {
                DB::commit();
                session()->flash('success', __('site.updated_successfully'));
                return redirect()->back()->withErrors(__('translation.' . $e->getMessage()))->withInput();
                // if ($e->getCode() == 50)   session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
            }
            DB::commit();
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->back()->withErrors(__('translation.' . $e->getMessage()))->withInput();
            // if ($e->getCode() == 50)   session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
           
            if ($e->getCode() == 50) {
                DB::commit(); 
                session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
                return redirect()->back();
            }
       
        } 
      
        
    } //end of destroy


    public function EmployeeSalaries(Request $request)
    {
// return $request->school_id;
        $request->validate([
            'school_id' => 'required',
            'teachers_id' => 'required',
            'month_number' => 'required|numeric',
            'year' => 'required|numeric',
        ]);
        $s = $request->school_id;
        $m = $request->teachers_id;
        $q = $request->month_number;
        $y = $request->year;

        $s  = school_salaries::where([
            ['teachers_id', $m],
            ['month_number', $q],
            ['year', $y]
        ])->get();
        // return $s->count();
        $r = $s->count();

        if ($r === 0) {
            $allowances = school_teachers_allowances::where([
                ['status', 1],
                ['teachers_id', $m]
            ])->get();
            $employees = school_teachers::findorfail($m);
            $employee_advances  = school_advances::where([['teachers_id', $m], ['month_number', $q], ['year', $y]])->get();
            return view('admin.School_teachers.School_salaries.salaries_show', compact('employee_advances', 'employees', 'q', 'y','s', 'allowances'));
        } else {
            session()->flash('error',  __('site.Salary_has_already_been_submitted'));
            return redirect()->back();
        }
    }
    public function print_salaries(Request $request, $id)
    {
        // dd('ok');
        $salaries = school_salaries::findOrFail($id);
        return view('admin.School_teachers.School_salaries.print', compact('salaries'));
    }
    public function teachers_salaries($id)
    {
        $teachers = DB::table("school_teachers")->where([["school_id", $id],['status' , 1],['deleted_at' ,NULL]])->pluck("name", "id");
       
        return json_encode($teachers);
    }
}//end of controller