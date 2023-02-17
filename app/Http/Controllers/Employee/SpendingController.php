<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\spendings;
use App\Models\section;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\spendingRequest;
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


    public function store(Request $request)
    {
        // return  $request;

        $list_spending = $request->list_spending;
        try {
            foreach ($list_spending as $list_spendings) {

                $spendings = new spendings();
                $spendings->section_id = $list_spendings['section_id'];
                $spendings->spending_name = $list_spendings['spending_name'];
                $spendings->month = $list_spendings['month'];
                $spendings->spending_value = $list_spendings['spending_value'];
                $spendings->description = $list_spendings['description'];
                $spendings->save();
            }
            //    return  $DATA;
            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route('Employee.spending.index');
        } catch (Exception $e) {
            dd($e);
            session()->flash('error',  'Some Thing Went Worng ');
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

    public function update(spendingRequest $request)
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
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('Employee.spending.index');
        }catch(Exception $e){
            dd($e);
            session()->flash('error' ,  'Some Thing Went Worng ');
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