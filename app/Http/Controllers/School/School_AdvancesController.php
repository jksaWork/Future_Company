<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\school_teachers;
use App\Models\school_advances;
use App\Models\school_teachers_allowances;
use App\Models\school_salaries;
use App\Models\SchoolTreasuryTransactionHistory;
use App\Models\school_types;
use Illuminate\Support\Facades\DB;
// use App\Http\Requests\Request;
use Illuminate\Http\Request;
use Exception;

class School_AdvancesController extends Controller
{

    public function index(Request $request)
    {

        // $Advances = Advances::all();
        $school_id =school_types::all();
        return view('admin.School_teachers.School_Advances.index',compact('school_id'));
    } //end of index


    public function create()
    {
        $school_types = school_types::all();
        $employees = school_teachers::where([['status', 1],])->get();
        return view('admin.School_teachers.School_Advances.create', compact('employees','school_types'));
    } //end of create


    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'teachers_id' => 'required',
            'school_id' => 'required',
            'advances_value' => 'required|numeric',
            'month_number' => 'required',
            'year' => 'required|numeric',
        ]);
        DB::beginTransaction();
        try {
            $salaries  = school_salaries::where([['teachers_id', $request->teachers_id], ['month_number', $request->month_number], ['year', $request->year]])->get();
             $salaries =  $salaries->count();
                  if ($salaries == 0) {
// dd('ok');


            $employee_advances  = school_advances::where([['teachers_id', $request->teachers_id], ['month_number', $request->month_number], ['year', $request->year]])->get();

           
            $allowances = school_teachers_allowances::where([
                ['status', 1],
                ['teachers_id', $request->teachers_id]
                ])->get();

                $employee = school_teachers::find($request->teachers_id);

                $sum_allowances = 0;
                foreach ($allowances as $index => $allowances) {
                    $sum_allowances += $allowances->Allowances_id->	allowances_value;
                }
 

                $sum_advances_value = 0;
                foreach ($employee_advances as $index => $Advancess) {
                    $sum_advances_value += $Advancess->advances_value;
                }


                
                $sum_advances = $sum_advances_value + $request->advances_value;
                $sum_employee = $employee->salary + $sum_allowances;
                // return $sum_employee;
                // return  $sum_advances ;

            if ($sum_advances  <= $sum_employee) {
                $advance = school_advances::create([
                    'teachers_id' => $request->teachers_id,
                    'school_id' => $request->school_id,
                    'year' => $request->year,
                    'advances_value' => $request->advances_value,
                    'month_number' => $request->month_number,
                ]);

                $advances = school_advances::findOrFail($advance->id);
                $res = SchoolTreasuryTransactionHistory::MakeTransacaion( $advances->advances_value, 'advance', $advances->teachers->name .'-'.$advances->School->school_name , $advances->id);

                $advances->update([
                    'Transaction_id' => $res->id,
                ]);
                DB::commit();
                session()->flash('success', __('site.added_successfully'));
                return redirect()->route('School.Advances.index');
            } else {
                session()->flash('error',  __('site.You_have_exceeded_the_salary_imit'));
                return redirect()->back();
            }
        } else {
            session()->flash('error',  __('site.This_month_salary_was_delivered_earlier'));
                return redirect()->back();
        }

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

        // $employees = employee::findorfail($id);
        // // return $employees;
        // return view('admin.School_teachers.School_Advances.create', compact('employees'));
    }


    public function edit(Request $request, $id)
    {
        // return $id;
        $school_types = school_types::all();
        $employees = school_teachers::where([['status', 1],])->get();
        $Advancess = school_Advances::find($id);
        // return $Advancess;
        return view('admin.School_teachers.School_Advances.edit', compact('Advancess', 'employees','school_types'));
    } //end of edit

    public function update(Request $request,  $id)
    {
        // return $request;
        $request->validate([
            'teachers_id' => 'required',
            'school_id' => 'required',
            'advances_value' => 'required|numeric',
            'month_number' => 'required',
            'year' => 'required|numeric',
        ]);
        DB::beginTransaction();
        try {
            $employee_advances  = school_advances::where([['teachers_id', $request->teachers_id], ['month_number', $request->month_number], ['year', $request->year]])->get();
            $Advancess = school_advances::findOrFail($id);

            $allowances = school_teachers_allowances::where([
                ['status', 1],
                ['teachers_id', $request->teachers_id]
                ])->get();

                $employee = school_teachers::find($request->teachers_id);

                $sum_allowances = 0;
                foreach ($allowances as $index => $allowances) {
                    $sum_allowances += $allowances->Allowances_id->	allowances_value;
                }
 

                $sum_advances_value = 0;
                foreach ($employee_advances as $index => $Advancess) {
                    $sum_advances_value += $Advancess->advances_value;
                }


                // return  $allowances ;
                $sum_advances = $sum_advances_value + $request->advances_value - $Advancess->advances_value;
              
        //    return   $sum_advances;
                $sum_employee = $employee->salary + $sum_allowances;
                

            if ($sum_advances  <= $sum_employee) {
            $Advancess = school_advances::findOrFail($id);

            $Advancess->update([
                'teachers_id' => $request->teachers_id,
                'school_id' => $request->school_id,
                'advances_value' => $request->advances_value,
                'year' => $request->year,
                'month_number' => $request->month_number,
            ]);
            // return  $Advancess->advances_value;
            $res = SchoolTreasuryTransactionHistory::EditTransaction($Advancess->Transaction_id, $Advancess->advances_value);

            DB::commit();
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('School.Advances.index');
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

    public function destroy($id)
    {
        try{
        $Advances = school_advances::findOrFail($id);
        $res = SchoolTreasuryTransactionHistory::DestoryTransaction( $Advances->Transaction_id);
        $Advances->delete();
        session()->flash('error', __('site.has_been_transferred_successfully'));
        return redirect()->route('School.Advances.index');

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
    } //end of destroy
}
public function teachers($id){
    $teachers = DB::table("school_teachers")->where([["school_id", $id],['status' , 1]])->pluck("name", "id");
       
    return json_encode($teachers);
}



}//end of controller
