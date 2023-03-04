<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\allowances;
use App\Models\salaries;
use App\Models\employee;
use App\Models\Advances;
use App\Models\section;
use App\Models\spendings;
use App\Models\Category;
use App\Models\employee_allowances;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

class DataController extends Controller
{


    public function SectionhistoryData(Request $request)
    {


        $query = section::query();
        return  DataTables::of($query)->editColumn(
            'actions',
            'admin.Employee.section.data_table.actions'
        )
            ->rawColumns(['actions'])
            ->toJson();
    } //end of SectionhistoryData

    public function spendinghistoryData(Request $request)
    {


        $query = spendings::query();
        return  DataTables::of($query)->editColumn(
            'actions',
            'admin.Employee.spending.data_table.actions'
        )->editColumn('section_id', function ($item) {
            return "<span class='badge badge-success'>" . $item->section->section_name . "</span>";
        })
            ->editColumn('spending_value', function ($item) {
                return number_format($item->spending_value, 2);
            })
            ->rawColumns(['actions', 'section_id'])
            ->toJson();
    } //end of spendinghistoryData
    public function CategoryhistoryData(Request $request)
    {


        $query = Category::query();
        return  DataTables::of($query)->editColumn(
            'actions',
            'admin.Employee.categories.data_table.actions'
        )

            ->rawColumns(['actions'])
            ->toJson();
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
        $query = employee_allowances::query()->where('status', 0);
        return  DataTables::of($query)
            ->editColumn(
                'actions',
                'admin.Employee.employee_allowances.data_table.actions'
            )
            ->editColumn('employee_id', function ($item) {
                return  $item->employee->name;

               
            })
            ->editColumn('allowances_id', function ($item) {
                return "<span class='badge badge-light-info'>". $item->Allowances_id->allowances_name . ' ( ' . $item->Allowances_id->allowances_value  . ' ) ' . '</span>';
            })

       
            
            ->editColumn('created_at', function ($item) { 
                return $item->created_at->format('Y-m-d');
            })

            ->rawColumns(['actions', 'employee_id', 'allowances_id' , 'created_at'])
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
                return number_format($item->advances_value, 2) ;
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
                return "<span class='badge badge-success'>". $item->getActive() .'</span>';
            })

            ->rawColumns(['actions', 'employee_id', 'created_at','status'])
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
                return number_format($item->allowances_value, 2) ;
            })
            ->editColumn('status', function ($item) {
                return "<span class='badge badge-success'>". $item->getActive() .'</span>';
            })

            ->rawColumns(['actions', 'allowances_value', 'created_at','status'])
            ->toJson();
    } //end of salarieshistoryData

    public function ChangeStatus($id)
    {
        $employee = employee::findOrFail($id);
        $employee->ChangeStatus();
        return redirect()->back();
    }
 
}//end of controller
