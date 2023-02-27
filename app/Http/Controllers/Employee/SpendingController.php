<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\spendings;
use App\Models\section;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SpendingRequest;
use Illuminate\Http\Request;
use Exception;

class SpendingController extends Controller
{

    public function index(Request $request)
    {
        // return $request;
        $spending = spendings::all();
// dd($spending);
        return view('admin.Employee.spending.index', compact('spending'));
    } //end of index


    public function create()
    {

        $sections = section::all();
        return view('admin.Employee.spending.create', compact('sections'));
    } //end of create


    public function store(SpendingRequest $request)
    {
        // return  $request;

        $list_spending = $request->list_spending;
        DB::beginTransaction();
        try {
            $DATA = spendings::create([
                'section_id' => $request->section_id,
                'spending_name' => $request->spending_name,
                'month' => $request->month,
                'spending_value' => $request->spending_value,
                'description' => $request->description,

            ]);
            //    return  $DATA;
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('Employee.spending.index');
        } catch (Exception $e) {
            DB::rollback();
            //dd($e);
            session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }
    } //end of store


    public function show($id)
    {

        $spendings = spendings::findorfail($id);
        return view('admin.Employee.spending.show',compact('spendings','images'));
    }


    public function edit(Request $request, $id)
    {
        $sections = section::all();
        // return $Categorys;
        $spendings = spendings::find($id);
        return view('admin.Employee.spending.edit', compact('spendings', 'sections'));
    } //end of edit

    public function update(SpendingRequest $request)
    {
        // return $request;
        try{

        $id = section::where('section_name', $request->section_id)->first()->id;
        //    return $id;
        $spending = spendings::findOrFail($request->pro_id);

        $spending->update([
            'spending_name' => $request->spending_name,
            'month' => $request->month,
            'spending_value' => $request->spending_value,
            'section_id' => $id,
            'description' => $request->description,
        ]);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('Employee.spending.index');
        }catch(Exception $e){
            //dd($e);
            session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }

    } //end of update

    public function destroy( $id)
    {
        // return $id;
        $spending = spendings::findOrFail($id);
        $spending->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('Employee.spending.index');
    } //end of destroy



}//end of controller
