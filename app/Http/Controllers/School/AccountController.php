<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\school_sections;
use App\Models\school_types;
use App\Models\school_spendings;
use App\Models\type_accounts;
use Illuminate\Support\Facades\Validator;
use App\Models\SchoolTreasuryTransactionHistory;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\spendingRequest as SpendingRequest;
use App\Http\Requests\updataSpendingRequest;
use Illuminate\Http\Request;
use Exception;

class AccountController extends Controller
{

    public function index(Request $request)
    {
          } //end of index


    public function create()
    {
         } //end of create


    public function store(Request $request)
    {

        $request->validate([
            'month' => 'required|date_format:Y-m-d',
            'value' => 'required|min:0|numeric',
        ]);
        DB::beginTransaction();

        try {
            if ($request->status == 1) {
            $type_account = type_accounts::create([
                'school_spendings_id' => $request->pro_id,
                'value' => $request->value,
                'status' => $request->status,
                'month'=> $request->month,
                'description' => $request->description,

            ]);
            // return $type_account;
            $spendingses = school_spendings::findOrFail($request->pro_id);
            $spendingses->update([
                'spending_value' =>  $spendingses->spending_value + $type_account->value ,
            ]);
            DB::commit();
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('School.spending.index');

        } else {
            $spendingses = school_spendings::findOrFail($request->pro_id);
            if ($request->value <= $spendingses->spending_value) {
          
            $type_account = type_accounts::create([
                'school_spendings_id' => $request->pro_id,
                'value' => $request->value,
                'status' => $request->status,
                'month'=> $request->month,
                'description' => $request->description,

            ]);
            // return $type_account;
           
            $type_accounts = type_accounts::findOrFail($type_account->id);
            //    return  $spendingses->spending_value;
            $res = SchoolTreasuryTransactionHistory::MakeTransacaion($type_accounts->value, 'spending', $spendingses->spending_name . '-' . $spendingses->School->school_name, $spendingses->school_id, $type_accounts->id);

            $type_accounts->update([
                'Transaction_id' => $res->id,
            ]);
            $spendingses->update([
                'spending_value' =>  $spendingses->spending_value - $type_account->value ,
            ]);
            DB::commit();
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('School.spending.index');
        } else {
            session()->flash('error', __('site.The_amount_entered_is_greater_than_the_customer_account'));
            return redirect()->route('School.spending.index');
        }
        }
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

    }


    public function edit(Request $request, $id)
    {
       
        $type_accounts = type_accounts::find($id);
        return view('admin.School_teachers.School_spending.edite_account', compact('type_accounts'));
    } //end of edit

    public function update(Request $request , $id)
    {
        // return $request;
        $request->validate([
            
            'month' => 'required|date_format:Y-m-d',
            'value' => 'required|min:0|numeric',
        ]);
        DB::beginTransaction();
        try {

            if ($request->status == 1) {
                
                $spendingses = school_spendings::findOrFail($request->pro_id);
                $pluss = type_accounts::findOrFail($id);
               $sum_pluss =$request->value - $pluss->value ;
                $pluss->update([
                    'school_spendings_id' => $request->pro_id,
                    'value' => $request->value,
                    'status' => $request->status,
                    'month'=> $request->month,
                    'description' => $request->description,
    
                ]);
               
                $spendingses->update([
                    'spending_value' =>  $spendingses->spending_value + $sum_pluss ,
                ]);
                DB::commit();
                session()->flash('success', __('site.added_successfully'));
                return redirect()->route('School.spending.index');
    
            } else {
                $spendingses = school_spendings::findOrFail($request->pro_id);
                if ($request->value <= $spendingses->spending_value) {
                $mouns = type_accounts::findOrFail($id);
               $sum_mouns =$request->value - $mouns->value ;
                $mouns->update([
                    'school_spendings_id' => $request->pro_id,
                    'value' => $request->value,
                    'status' => $request->status,
                    'month'=> $request->month,
                    'description' => $request->description,
    
                ]);
                $spendingses->update([
                    'spending_value' =>  $spendingses->spending_value - $sum_mouns ,
                ]);
                
                 $res = SchoolTreasuryTransactionHistory::EditTransaction($mouns->Transaction_id, $mouns->value);
           
               
                DB::commit();
                session()->flash('success', __('site.added_successfully'));
                return redirect()->route('School.spending.index');
            } else {
                session()->flash('error', __('site.The_amount_entered_is_greater_than_the_customer_account'));
                return redirect()->route('School.spending.index');
            }
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

    public function pluss_spending($id)
    {
        return $id;
        $spending = school_spendings::findOrFail($id);
        return view('admin.School_teachers.School_spending.account', compact('spending'));

        
    } //end of destroy



}//end of controller