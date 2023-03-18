<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\allowances;
use App\Models\salaries;
use App\Models\employee;
use App\Models\Advances;
use App\Models\spending;
use App\Models\spendings;
use App\Models\Category;
use App\Models\employee_allowances;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
// use App\Http\Requests\Request;
use Illuminate\Http\Request;
use Exception;
use PhpParser\Node\Stmt\Return_;
use Illuminate\Support\Facades\DB;
// use DB;

class ReportController extends Controller
{


    public function report_spending(Request $request)
    {
        $e = $request->end_month;
        $b = $request->being_month;
        if ($b == null or $e == null) {
            $spendings = spendings::all();
            return view('admin.Employee.Repoet.index', compact('spendings'));
        } else {
            $spendings = spendings::whereBetween('created_at', [$b, Carbon::parse($e)->endOfDay(),])->get();
            return view('admin.Employee.Repoet.index', compact('spendings'));
        }
    } //end of SectionhistoryData

    public function report_employee(Request $request)
    {
        // return $request;
        $e = $request->end_month;
        $b = $request->being_month;

        if ($b == null or $e == null) {

            $employee = employee::where('status', 1)->get();
            $allowancesS = employee_allowances::where('status', 1)->get();
            // return  $employee;
            return view('admin.Employee.Repoet.employee', compact('employee', 'allowancesS'));
        } else {
            // dd('ok');
            $employee = employee::where('status', 1)->whereBetween('created_at', [$b, Carbon::parse($e)->endOfDay(),])->get();
            $allowancesS = employee_allowances::where('status', 1)->get();
            return view('admin.Employee.Repoet.employee', compact('employee', 'allowancesS'));
            return  $employee;
        }
    } //end of spendinghistoryData
    public function report_employee_allowances(Request $request)
    {


        $e = $request->end_month;
        $b = $request->being_month;
        if ($b == null or $e == null) {

            $employee_allowances = employee_allowances::where('status', 0)->get();
            return view('admin.Employee.Repoet.employee_allowances', compact('employee_allowances'));
        } else {
            $employee_allowances = employee_allowances::where('status', 0)->whereBetween('created_at', [$b, Carbon::parse($e)->endOfDay(),])->get();

            return view('admin.Employee.Repoet.employee_allowances', compact('employee_allowances'));
        }
    } //end of CategoryhistoryData


    public function report_salaries(Request $request)
    {


        $e = $request->end_month;
        $b = $request->being_month;
        if ($b == null or $e == null) {

            $salaries = salaries::where('status', 1)->get();
            return view('admin.Employee.Repoet.salaries', compact('salaries'));
        } else {
            $salaries = salaries::where('status', 1)->whereBetween('created_at', [$b, Carbon::parse($e)->endOfDay(),])->get();

            return view('admin.Employee.Repoet.salaries', compact('salaries'));
        }
    } //end of CategoryhistoryData


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
}//end of controller
