<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\employee_allowances;
use App\Models\school_types;
use App\Models\FinancialTreasuryTransactionHistorys;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Employee_allowancesRequest;
use Illuminate\Http\Request;
use Exception;

class school_TypeController extends Controller
{

    public function index(Request $request)
    {
       
      
        return view('admin.School_teachers.school_type.index');
    } //end of index


    public function create(Employee $employee)
    {
       
        return view('admin.School_teachers.school_type.create');

        // return view('admin.Employee.employee_allowances.create');
    } //end of create


    public function store(Request $request)
    {
    // return $request;
        $request->validate([
            'school_name' =>'required',
        ]);

// return $request;
        // DB::beginTransaction();
        try {
           $dd = school_types::create([
                'school_name'   => $request->school_name,
                'description' => $request->description,
            ]);
            // return $dd;
            // DB::commit();
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('School.school_type.index');
        } catch (Exception $e) {
            dd($e);
            session()->flash('error',  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }
    } //end of store


    public function show($id)
    {
        // $allowances =allowances::where([
        //     ['status',  0],
        // ])->get();
        // $allowances =allowances::all();
        $employees = employee::findorfail($id);
        // return $employees;
        return view('admin.Employee.employee_allowances.create',compact('employees' , 'allowances'));
    }


    public function edit( $id)
    {
        $school_type = school_types::findorfail($id);

        return view('admin.School_teachers.school_type.edit', compact('school_type'));
    } //end of edit

    public function update(Request $request,$id)
    {
        $request->validate([
            'school_name' =>'required',
        ]);


// return $id;
        DB::beginTransaction();
        try{

        $school_types = school_types::findOrFail($id);
        $school_types->update([

            'school_name'   => $request->school_name,
            'description' => $request->description,
        ]);
        DB::commit();
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('School.school_type.index');
        }catch(Exception $e){
            // dd($e);
            DB::rollBack();
            session()->flash('error',  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }

    } //end of update

    public function destroy( Employee $employee , $id)
    {
        // return $id;
        try{
        $employemployee_allowancesee = employee_allowances::findOrFail($id);  
        // return $employemployee_allowancesee->Transaction_id;
        $res = FinancialTreasuryTransactionHistorys::DestoryTransaction( $employemployee_allowancesee->Transaction_id);
 
        $employemployee_allowancesee->delete();
        session()->flash('error', __('site.has_been_transferred_successfully'));
        return redirect()->route('Employee.employee_allowances.index');
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



}//end of controller
