<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\school_sections;
use App\Models\school_types;
use App\Models\school_spendings;
use Illuminate\Support\Facades\Validator;
use App\Models\SchoolTreasuryTransactionHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\spendingRequest as SpendingRequest;
use App\Http\Requests\updataSpendingRequest;
use Illuminate\Http\Request;
use Exception;

class School_SpendingController extends Controller
{

    public function index(Request $request)
    {
        $school_id =school_types::all();
        return view('admin.School_teachers.School_spending.index', compact('school_id'));
    } //end of index


    public function create()
    {
        $school_id = school_types::all();
        $school_sections = school_sections::all();
        return view('admin.School_teachers.School_spending.create', compact('school_id','school_sections'));
    } //end of create


    public function store(Request $request)
    {

        // return $request;
        $request->validate([
            'school_id' =>'required|exists:school_types,id',
            'spending_name' => 'required|string|max:100',
            'section_id' => 'required|exists:school_sections,id',
            'month' => 'required|date_format:Y-m-d',
            'spending_value' => 'required|min:0|numeric',
        ]);
        DB::beginTransaction();

        try {
            $school_spendings = school_spendings::create([
                'section_id' => $request->section_id,
                'school_id' => $request->school_id,
                'spending_name' => $request->spending_name,
                'month' => $request->month,
                'spending_value' => $request->spending_value,
                'description' => $request->description,

            ]);
            // return $school_spendings;
            $spendingses = school_spendings::findOrFail($school_spendings->id);
            //    return  $spendingses->spending_value;
            $res = SchoolTreasuryTransactionHistory::MakeTransacaion($spendingses->spending_value, 'spending', $spendingses->spending_name . '-' . $spendingses->School->school_name, $school_spendings->id);

            $spendingses->update([
                'Transaction_id' => $res->id,
            ]);
            DB::commit();
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('School.spending.index');
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

        // $spendings = spendings::findorfail($id);
        return view('admin.School_teachers.School_spending.show', compact('spendings', 'images'));
    }


    public function edit(Request $request, $id)
    {
       
        $school_types =school_types::all();
        $school_sections =school_sections::all();
        $school_spendings = school_spendings::find($id);
        return view('admin.School_teachers.School_spending.edit', compact('school_types', 'school_sections','school_spendings'));
    } //end of edit

    public function update(Request $request , $id)
    {
        // return $request;
        $request->validate([
            'school_id' =>'required|exists:school_types,id',
            'spending_name' => 'required|string|max:100',
            'section_id' => 'required',
            'month' => 'required|date_format:Y-m-d',
            'spending_value' => 'required|min:0|numeric',
        ]);
        DB::beginTransaction();
        try {

          
            $school_spendings = school_spendings::findOrFail($id);

            $school_spendings->update([
                'section_id' => $request->section_id,
                'school_id' => $request->school_id,
                'spending_name' => $request->spending_name,
                'month' => $request->month,
                'spending_value' => $request->spending_value,
                'description' => $request->description,
            ]);
            // return $spending->Transaction_id;
            $res = SchoolTreasuryTransactionHistory::EditTransaction($school_spendings->Transaction_id, $school_spendings->spending_value);
            // return $res;
            DB::commit();
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('School.spending.index');
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
        try{
        $school_spendings = school_spendings::findOrFail($id);
        $res = SchoolTreasuryTransactionHistory::DestoryTransaction( $school_spendings->Transaction_id);
        $school_spendings->delete();
        session()->flash('error', __('site.has_been_transferred_successfully'));
        return redirect()->route('School.spending.index');
    } catch (Exception $e) {
        dd($e);
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

    public function print_spending($id)
    {
        $spending = school_spendings::findOrFail($id);
        return view('admin.School_teachers.School_spending.print', compact('spending'));

        
    } //end of destroy

    public function getproducts($id)
    {
        // return $id;
        $section_id = DB::table("school_sections")->where("school_id", $id)->pluck("section_name", "id");
       
        return json_encode($section_id);
    }



}//end of controller