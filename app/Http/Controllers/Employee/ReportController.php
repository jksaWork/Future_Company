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

class ReportController extends Controller
{


    public function report_spending(Request $request)
    {
        $e = $request->end_month;
        $b = $request->being_month;
        if ($b == null OR $e ==null) {
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
        if ($b == null OR $e ==null) {
         
            $employee = employee::all();
            $allowancesS = employee_allowances::where('status' ,1)->get();
            return view('admin.Employee.Repoet.employee', compact('employee','allowancesS'));
        
            
            
        } else {
            $employee = employee::whereBetween('created_at', [$b, Carbon::parse($e)->endOfDay(),])->get();
            $allowancesS = employee_allowances::where('status' ,1)->get();
            return view('admin.Employee.Repoet.employee', compact('employee','allowancesS'));
        }
    } //end of spendinghistoryData
    public function report_employee_allowances(Request $request)
    {


        $e = $request->end_month;
        $b = $request->being_month;
        if ($b == null OR $e ==null) {
         
            $employee_allowances = employee_allowances::where('status' ,0)->get();
            return view('admin.Employee.Repoet.employee_allowances', compact('employee_allowances'));
        
            
            
        } else {
            $employee_allowances = employee_allowances::where('status' ,0)->whereBetween('created_at', [$b, Carbon::parse($e)->endOfDay(),])->get();
            
            return view('admin.Employee.Repoet.employee_allowances', compact('employee_allowances'));
        }
    } //end of CategoryhistoryData
    public function employeeshistoryData(Request $request)
    {
        $str = '';
        $query = employee::query();
        return  DataTables::of($query)
            ->addColumn('allowances_id', function ($item) use ($str) {
                $allowancesS = employee_allowances::where(['employee_id' => $item->id,  'status' => 1])->get();
                foreach ($allowancesS as $key => $allowances) {
                    $str .= "<span class='badge badge-light-info'>" . $allowances->Allowances_id->allowances_name . ' ( ' . $allowances->Allowances_id->allowances_value  . ' ) ' . '</span>';
                }
                // DD($str);
                return $str;
            })
            ->editColumn(
                'actions',
                'admin.Employee.All_Employee.data_table.actions'
            )->editColumn('categories_id', function ($item) {
                return "<span class='badge badge-light-info'>" . $item->Categorys->categories_name . "</span>";
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

            ->rawColumns(['actions', 'categories_id', 'status', 'allowances_id'])
            ->toJson();
    } //end of employeeshistoryData




    public function employee_allowanceshistoryData(Request $request)
    {
        $str = '';
        $query = employee_allowances::query();
        return  DataTables::of($query)
            ->editColumn(
                'actions',
                'admin.Employee.employee_allowances.data_table.actions'
            )

            ->editColumn('allowances_id', function ($item) {
                return "<span class='badge badge-light-info'>" . $item->Allowances_id->allowances_name . ' ( ' . $item->Allowances_id->allowances_value  . ' ) ' . '</span>';
            })

            ->editColumn('employee_id', function ($item) {
                return  $item->employee->name;
            })
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })

            ->rawColumns(['actions', 'employee_id', 'created_at', 'allowances_id'])
            ->toJson();
    } //end of employee_allowanceshistoryData
    public function AdvanceshistoryData(Request $request)
    {
        $str = '';
        $query = Advances::query();
        return  DataTables::of($query)
            ->editColumn(
                'actions',
                'admin.Employee.Advances.data_table.actions'
            )
            ->editColumn('employee_id', function ($item) {
                return  $item->employee->name;
            })
            ->editColumn('advances_value', function ($item) {
                return number_format($item->advances_value, 2);
            })


            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })

            ->rawColumns(['actions', 'employee_id', 'created_at', 'advances_value'])
            ->toJson();
    } //end of AdvanceshistoryData

    public function salarieshistoryData(Request $request)
    {
        $str = '';
        $query = salaries::query();
        return  DataTables::of($query)
            ->editColumn(
                'actions',
                'admin.Employee.salaries.data_table.actions'
            )
            ->editColumn('employee_id', function ($item) {
                return  $item->employee->name;
            })
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->editColumn('status', function ($item) {
                return "<span class='badge badge-success'>" . $item->getActive() . '</span>';
            })

            ->rawColumns(['actions', 'employee_id', 'created_at', 'status'])
            ->toJson();
    } //end of salarieshistoryData

    public function allowanceshistoryData(Request $request)
    {
        $str = '';
        $query = allowances::query();
        return  DataTables::of($query)
            ->editColumn(
                'actions',
                'admin.Employee.allowances.data_table.actions'
            )
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->editColumn('allowances_value', function ($item) {
                return number_format($item->allowances_value, 2);
            })
            ->editColumn('status', function ($item) {
                return "<span class='badge badge-success'>" . $item->getActive() . '</span>';
            })

            ->rawColumns(['actions', 'allowances_value', 'created_at', 'status'])
            ->toJson();
    } //end of salarieshistoryData



}//end of controller
