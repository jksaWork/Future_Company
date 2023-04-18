<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\school_teachers;
use App\Models\school_teachers_allowances;
use App\Models\School_allowances;
use App\Models\school_types;
use App\Models\SchoolTreasuryTransactionHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Employee_allowancesRequest;
use Illuminate\Http\Request;
use Exception;

class School_TeachersAllowancesController extends Controller
{

    public function index(Request $request)
    {
        $school_id =school_types::all();
        return view('admin.School_teachers.School_teachers_allowances.index', compact('school_id'));
    } //end of index


    public function create(Request $request)
    {
        $school_id =school_types::all();
        $employees =school_teachers::where([
            ['status',  1],
        ])->get();
        $allowances =School_allowances::where([
            ['status',  0],
        ])->get();
        // return $allowances;
        return view('admin.School_teachers.School_teachers_allowances.create', compact('employees','allowances','school_id'));

        // return view('admin.School_teachers.School_employee_allowances.create');
    } //end of create


    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'allowances_id' =>'required',
            'teachers_id' => 'required',
            'month_number'=>'required',
            'school_id'=>'required',
            'year'=>'required',
        ]);


        DB::beginTransaction();
        try {
           $employee_allow = school_teachers_allowances::create([
                'teachers_id'   => $request->teachers_id,
                'allowances_id' => $request->allowances_id,
                'school_id' => $request->school_id,
                'year'=> $request->year,
                'status' => 0,
                'month_number' => $request->month_number,
            ]);
            $employee_allow = school_teachers_allowances::findOrFail($employee_allow->id);

            //    return  $spendingses->spending_value;
            
            $res = SchoolTreasuryTransactionHistory::MakeTransacaion($employee_allow->Allowances_id->allowances_value , 'incentives', $employee_allow->teachers->name . '-'.$employee_allow->Allowances_id->allowances_name ,
            $employee_allow->school_id , 
            $employee_allow->id);

            
          
           $d= $employee_allow->update([
                'Transaction_id' => $res->id,
            ]);
            
            DB::commit();
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('School.Teachers_allowances.index');
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
        // $allowances =allowances::where([
        //     ['status',  0],
        // ])->get();
        // // $allowances =allowances::all();
        // $employees = employee::findorfail($id);
        // // return $employees;
        // return view('admin.School_teachers.School_employee_allowances.create',compact('employees' , 'allowances'));
    }


    public function edit( $id)
    {
        // return $id;
        $employees = school_teachers::where([['status', 1],])->get();
    
        $allowances =School_allowances::where([
            ['status',  0],
        ])->get();
        $school_types =school_types::all();
        // $allowances =allowances::all();
        $employee_allowances = school_teachers_allowances::findorfail($id);

        return view('admin.School_teachers.School_teachers_allowances.edit', compact('allowances', 'employee_allowances','employees','school_types'));
    } //end of edit

    public function update(Request $request,$id)
    {
        // return $request;
        $request->validate([
            'allowances_id' =>'required',
            'teachers_id' => 'required',
            'school_id' => 'required',
            'month_number'=>'required',
            'year'=>'required',
        ]);



        DB::beginTransaction();
        try{

        $school_teachers_allowances = school_teachers_allowances::findOrFail($id);
        $school_teachers_allowances->update([

            'teachers_id'   => $request->teachers_id,
            'allowances_id' => $request->allowances_id,
            'year'=> $request->year,
            'school_id' => $request->school_id,
            'status' => 0,
            'month_number' => $request->month_number,
        ]);
        $res = SchoolTreasuryTransactionHistory::EditTransaction( $school_teachers_allowances->Transaction_id , $school_teachers_allowances->Allowances_id->allowances_value );

        DB::commit();
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('School.Teachers_allowances.index');
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

    public function destroy(  $id)
    {
        // return $id;
        try{
        $school_teachers_allowances = school_teachers_allowances::findOrFail($id);  
        // return $school_teachers_allowances->Transaction_id;
        $res = SchoolTreasuryTransactionHistory::DestoryTransaction( $school_teachers_allowances->Transaction_id);
 
        $school_teachers_allowances->delete();
        session()->flash('error', __('site.has_been_transferred_successfully'));
        return redirect()->route('School.Teachers_allowances.index');
    } catch (Exception $e) {
        if ($e->getCode() == 51) {
            DB::commit();
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->back()->withErrors(__('translation.' . $e->getMessage()))->withInput();
            // if ($e->getCode() == 50)   session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
        }
         
        if ($e->getCode() == 50) {
            DB::commit(); 
            session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
            return redirect()->back();
        }
        DB::rollBack();
        session()->flash('error',  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }
    } //end of destroy
    public function allowances_id($id){
        $allowances_id = DB::table("school_allowances")->where([["school_id", $id],['status' , 0],['deleted_at' ,NULL]])->pluck("allowances_name", "id");
       
        return json_encode($allowances_id);
    }
 public function teachers_id($id){
    $teachers_id = DB::table("School_teachers")->where([["school_id", $id],['status' , 1],['deleted_at' ,NULL]])->pluck("name", "id");
       
    return json_encode($teachers_id);
    }


}//end of controller
