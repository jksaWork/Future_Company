<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\School_allowances;
use App\Models\School_salaries;
use App\Models\school_teachers;
use App\Models\school_advances;
use App\Models\school_types;
use App\Models\school_sections;
use App\Models\school_spendings;
use App\Models\school_categories;
use App\Models\School_Teachers_allowances;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
// use App\Http\Requests\Request;
use Illuminate\Http\Request;
use Exception;
use PhpParser\Node\Stmt\Return_;
// use DB;
use Illuminate\Support\Facades\DB;

class School_ReportController extends Controller
{


    public function report_spending(Request $request)
    {
        $spendings = school_spendings::all();
        $school_id =school_types::all();
        return view('admin.School_teachers.School_Repoet.index', compact('spendings','school_id'));
    // }

  
    } //end of SectionhistoryData
     public function report_spending_data()
    {
        if (request()->being_month == null or request()->end_month ==null ) {
            $query = school_spendings::query()->where('school_id', request()->school_spendings);
        } else {
            $query = school_spendings::query()->whereBetween('created_at', [request()->being_month, Carbon::parse(request()->end_month)->endOfDay(),])->where('school_id', request()->school_spendings); 
        }
       if(request()->being_month == null and request()->end_month ==null and request()->school_spendings == null ){
        $query = school_spendings::query();
       }
        return  DataTables::of($query)
       
          
        ->editColumn('spending_total', function ($item) {
            return number_format($item->sum('spending_value'), 2);
        })
        
            ->editColumn('school_id', function ($item) {
                return "<span class='badge badge-success'>" . $item->school->school_name . "</span>";
            })
            ->editColumn('section_id', function ($item) {
                return "<span class='badge badge-primary'>" . $item->section->section_name . "</span>";
            })
            ->editColumn('spending_value', function ($item) {
                return number_format($item->spending_value, 2);
            })
            ->rawColumns([ 'school_id', 'section_id', 'spending_value','spending_total'])
            
            ->toJson();
    }

    public function report_employee(Request $request)
    {
        
        $school_id =school_types::all();
            return view('admin.School_teachers.School_Repoet.employee', compact('school_id'));
            // return  $employee;
        // }
    } //end of spendinghistoryData
    public function teachers(){
        $str = '';
        if (request()->being_month == null or request()->end_month ==null ) {
            $query = school_teachers::query()->where('school_id', request()->school_teachers);
        } else {
            $query = school_teachers::query()->whereBetween('month_number', [request()->being_month, Carbon::parse(request()->end_month)->endOfDay(),])->where('school_id', request()->school_teachers);
        }
       if(request()->being_month == null and request()->end_month ==null and request()->school_teachers == null ){
        $query = school_teachers::query();
       }
        return  DataTables::of($query)
        ->addColumn('allowances_id', function ($item) use ($str) {
            $allowancesS = School_Teachers_allowances::where(['teachers_id' => $item->id,  'status' => 1])->get();
            foreach ($allowancesS as $key => $allowances) {
                $str .= "<span class='badge badge-light-info'>" . $allowances->Allowances_id->allowances_name . ' ( ' . $allowances->Allowances_id->allowances_value  . ' ) ' . '</span>';
            }
            // DD($str);
            return $str;
        })
            ->addColumn('allowances_total', function ($item)  {
                $allowancesS = School_Teachers_allowances::where(['teachers_id' => $item->id,  'status' => 1])->get();
                // $str = $allowancesS->sum("allowances->Allowances_id->allowances_value");
               $str = 0;
                foreach ($allowancesS as $key => $allowances) {
                    $str += $allowances->Allowances_id->allowances_value;
                }
                return $str ;
            })
            ->editColumn('school_id', function ($item) {
                return "<span class='badge badge-primary'>" . $item->school->school_name . "</span>";
            })
            ->editColumn('salary', function ($item) {
                return number_format($item->salary, 2);
            })
            ->editColumn('categories_id', function ($item) {
                return "<span class='badge badge-success'>" . $item->Categorys->categories_name . "</span>";
            })
            ->editColumn('status', function ($item) {
                return $item->getStatusWithSpan();
            })

            ->rawColumns([ 'categories_id', 'status', 'allowances_id', 'school_id' ,'allowances_total'])
            ->toJson();
    }
    public function report_employee_allowances(Request $request)
    {
 $school_id =school_types::all();
            return view('admin.School_teachers.School_Repoet.employee_allowances', compact('school_id'));
        // }
    } //end of CategoryhistoryData
    public function report_employee_allowances_data(){
        $str = '';
        if (request()->being_month == null or request()->end_month ==null ) {
            $query = school_teachers_allowances::query()->where('school_id', request()->school_teachers_allowances);
        } else {
            $query = school_teachers_allowances::query()->whereBetween('created_at', [request()->being_month, Carbon::parse(request()->end_month)->endOfDay(),])->where('school_id', request()->school_teachers_allowances);
        }
       if(request()->being_month == null and request()->end_month ==null and request()->school_teachers_allowances == null ){
        $query = school_teachers_allowances::query();
       }
        // $query = school_teachers_allowances::query()->where('status', 0);
        return  DataTables::of($query)
           
            ->editColumn('teachers_id', function ($item) {
                return  $item->teachers->name;
            })
            ->editColumn('allowances_id', function ($item) {
                return "<span class='badge badge-light-info'>" . $item->Allowances_id->allowances_name . '</span>';
            })

            ->addColumn('allowances_total', function ($item)  {
              
                return $item->Allowances_id->allowances_value ;
            })

            ->editColumn('school_id', function ($item) {
                return "<span class='badge badge-primary'>" . $item->school->school_name . "</span>";
            })

            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })

            ->rawColumns([ 'teachers_id', 'allowances_id', 'created_at', 'school_id','allowances_total'])
            ->toJson();
    }


    public function report_salaries(Request $request)
    {


        // $e = $request->end_month;
        // $b = $request->being_month;
        // if ($b == null or $e == null) {

        //     $salaries = School_salaries::where('status', 1)->get();
        //     return view('admin.School_teachers.School_Repoet.salaries', compact('salaries'));
        // } else {
        //     $salaries = School_salaries::where('status', 1)->whereBetween('created_at', [$b, Carbon::parse($e)->endOfDay(),])->get();
        $school_id =school_types::all();
            return view('admin.School_teachers.School_Repoet.salaries', compact('school_id'));
        // }
    } 
    public function report_salaries_data(Request $request)
    {
        if (request()->being_month == null or request()->end_month ==null ) {
            $query = School_salaries::query()->where('school_id', request()->School_salaries);
        } else {
            $query = School_salaries::query()->whereBetween('created_at', [request()->being_month, Carbon::parse(request()->end_month)->endOfDay(),])->where('school_id', request()->School_salaries); 
        }
       if(request()->being_month == null and request()->end_month ==null and request()->School_salaries == null ){
        $query = School_salaries::query();
       }
        $str = '';
        // $query = School_salaries::query();
        return  DataTables::of($query)
            
            ->editColumn('teachers_id', function ($item) {
                return  $item->teachers->name;
            })
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->editColumn('status', function ($item) {
                return "<span class='badge badge-success'>" . $item->getActive() . '</span>';
            })
            ->editColumn('school_id', function ($item) {
                return "<span class='badge badge-primary'>" . $item->school->school_name . "</span>";
            })

            ->rawColumns([ 'teachers_id', 'created_at', 'status', 'school_id'])
            ->toJson();
    } //


    public function MonthlyRealstateRenvueAndSpending()
    {
        return view('reports.monthly_renvue_speding');
    }

    public function MonthData()
    {
        $q = DB::table('financial_treasury_transaction_historys')->select(
            DB::raw("MONTH(created_at) AS mon , year(created_at) as yea "),
            DB::raw("(SELECT COALESCE(SUM(amount),0) AS amont from financial_treasury_transaction_historys WHERE type = 'credit' and MONTH(created_at) = mon and year(created_at) = yea ) as credit_total"),
            DB::raw("(SELECT COALESCE(SUM(amount),0) AS amont from financial_treasury_transaction_historys WHERE type = 'debit' and MONTH(created_at) = mon and year(created_at) = yea) as debit_total"),
            DB::raw("(SELECT credit_total - debit_total) as total")
        )
            ->when(request()->year != null, function ($q) {
                $q->whereYear('created_at', request()->year);
            })
            ->when(request()->month != null, function ($q) {
                $q->whereMonth('created_at', request()->month);
            })
            ->groupBy("mon", 'yea');

        return  DataTables::of($q)
            ->addColumn('month_name', function ($item) {
                return date("F", mktime(1, null, null, $item->mon, 1));
            })
            ->editColumn('credit_total', function ($item) {
                return number_format($item->credit_total, 2);
            })
            ->editColumn('debit_total', function ($item) {
                return number_format($item->debit_total, 2);
            })
            ->editColumn('total', function ($item) {
                return number_format($item->total, 2);
            })
            ->toJson();
    }
    public function spendings($id){
        $spendings = DB::table("school_spendings")->where([["school_id", $id],['status' , 1]])->pluck("name", "id");
       
        return json_encode($spendings);
    }
}//end of controller
