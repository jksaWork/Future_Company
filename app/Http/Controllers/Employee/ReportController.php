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
use DB;

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

        $e = $request->end_month;
        $b = $request->being_month;
        if ($b == null or $e == null) {

            $employee = employee::all();
            $allowancesS = employee_allowances::where('status', 1)->get();
            return view('admin.Employee.Repoet.employee', compact('employee', 'allowancesS'));
        } else {
            $employee = employee::whereBetween('created_at', [$b, Carbon::parse($e)->endOfDay(),])->get();
            $allowancesS = employee_allowances::where('status', 1)->get();
            return view('admin.Employee.Repoet.employee', compact('employee', 'allowancesS'));
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
        $q = "SELECT MONTH(created_at) AS mon ,
             (SELECT sum(amount) AS amont
          from financial_treasury_transaction_historys WHERE MONTH(created_at) = mon ) as amount
          from financial_treasury_transaction_historys
        GROUP BY MONTH(created_at);";
        $data['reports'] = DB::select('select sum() from users where active = ?', [1]);
        return view('reports.monthly_renvue_speding', $data);
    }
}//end of controller