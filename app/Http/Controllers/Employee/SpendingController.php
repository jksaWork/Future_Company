<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\spendings;
use App\Models\section;
use Illuminate\Support\Facades\Validator;
use App\Models\FinancialTreasuryTransactionHistorys;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\spendingRequest as SpendingRequest;
use App\Http\Requests\updataSpendingRequest;
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
        DB::beginTransaction();

        try {
            $spendings = spendings::create([
                'section_id' => $request->section_id,
                'spending_name' => $request->spending_name,
                'month' => $request->month,
                'spending_value' => $request->spending_value,
                'description' => $request->description,

            ]);
            // return $spendings;
            $spendingses = spendings::findOrFail($spendings->id);
            //    return  $spendingses->spending_value;
            $res = FinancialTreasuryTransactionHistorys::MakeTransacaion($spendingses->spending_value, 'spending', $spendingses->spending_name . '-' . $spendingses->section->section_name, $spendings->id);

            $spendingses->update([
                'Transaction_id' => $res->id,
            ]);
            DB::commit();
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('Employee.spending.index');
        } catch (Exception $e) {
            // dd($e);
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

        $spendings = spendings::findorfail($id);
        return view('admin.Employee.spending.show', compact('spendings', 'images'));
    }


    public function edit(Request $request, $id)
    {
        $sections = section::all();
        // return $Categorys;
        $spendings = spendings::find($id);
        return view('admin.Employee.spending.edit', compact('spendings', 'sections'));
    } //end of edit

    public function update(updataSpendingRequest $request)
    {
        // return $request;
        DB::beginTransaction();
        try {

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
            // return $spending->Transaction_id;
            $res = FinancialTreasuryTransactionHistorys::EditTransaction($spending->Transaction_id, $spending->spending_value);
            // return $res;
            DB::commit();
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('Employee.spending.index');
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
        $spending = spendings::findOrFail($id);
        $spending->delete();
        session()->flash('error', __('site.deleted_successfully'));
        return redirect()->route('Employee.spending.index');
    } //end of destroy

    public function print_spending($id)
    {
        $spending = spendings::findOrFail($id);
        return view('admin.Employee.spending.print', compact('spending'));
    } //end of destroy



}//end of controller