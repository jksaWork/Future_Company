<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\allowances;
use App\Models\salaries;
use App\Models\employee;
use App\Models\Advances;
use App\Models\spendings;
use App\Models\Category;
use App\Models\section;
use App\Models\employee_allowances;
use App\Models\FinancialTreasuryTransactionHistorys;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
// use App\Http\Requests\Request;
use Illuminate\Http\Request;
use Exception;
use PhpParser\Node\Stmt\Return_;

class AchiveController extends Controller
{


    public function Achive_section(Request $request)
    {

        // dd('ok');
        $section = section::onlyTrashed()->get();
        // return $section;

        return view('admin.Employee.Achive.Expense_sections.section', compact('section'));
        
       
    } //end of SectionhistoryData
    public function SectionAchive(Request $request)
    {


        $query = section::query()->onlyTrashed();
        return  DataTables::of($query)
        ->editColumn(
            'actions',
            'admin.Employee.Achive.Expense_sections.data_table.actions'
        )
            ->rawColumns(['actions'])
            ->toJson();
    } //end of SectionhistoryData

    public function SectionAchiveFeedback(Request $request, $id)
    {
        // $id = $request->invoice_id;
        $flight = section::withTrashed()->where('id', $id)->restore();
        session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('Achive.section.Achive');
        
       
    } //end of SectionhistoryData




    public function Achive_spending(Request $request)
    {

        // dd('ok');
        $spending = spendings::onlyTrashed()->get();
        // return $spending;

        return view('admin.Employee.Achive.spending.spending', compact('spending'));
        
       
    } //end of spendinghistoryData
    public function spendingAchive(Request $request)
    {
        $query = spendings::query()->onlyTrashed();
        return  DataTables::of($query)->editColumn(
            'actions',
            'admin.Employee.Achive.spending.data_table.actions'
        )
        
        ->editColumn('section_id', function ($item) {
            return "<span class='badge badge-success'>" . $item->section->section_name . "</span>";
        })
            ->editColumn('spending_value', function ($item) {
                return number_format($item->spending_value, 2);
            })
            ->rawColumns(['actions', 'section_id'])
            ->toJson();
    } //end of spendinghistoryData

    public function spendingAchiveFeedback(Request $request, $id)
    {
    //    return $id;
        $flight = spendings::withTrashed()->where('id', $id)->restore();
        $spending = spendings::findOrFail($id);
        // $res = FinancialTreasuryTransactionHistorys::MakeTransacaion($spending->spending_value, 'spending', $spending->spending_name . '-' . $spending->section->section_name, $spending->id);
        $res = FinancialTreasuryTransactionHistorys::EditTransaction( $spending->Transaction_id , $spending->spending_value);
        session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('Achive.spending.Achive');
        
       
    } //end of SectionhistoryData

  

    public function Achive_Category(Request $request)
    {

        // dd('ok');
        $categories = Category::onlyTrashed()->get();
        // return $Category;

        return view('admin.Employee.Achive.Category.Category', compact('categories'));
        
       
    } //end of CategoryhistoryData
    public function CategoryAchive(Request $request)
    {
        $query = Category::query()->onlyTrashed();
        return  DataTables::of($query)->editColumn(
            'actions',
            'admin.Employee.Achive.Category.data_table.actions'
        )

            ->rawColumns(['actions'])
            ->toJson();
    } //end of CategoryhistoryData

    public function CategoryAchiveFeedback(Request $request, $id)
    {
        // $id = $request->invoice_id;
        $flight = Category::withTrashed()->where('id', $id)->restore();
        session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('Achive.Category.Achive');
        
       
    } //end of SectionhistoryData


    public function Achive_allowances(Request $request)
    {

        // dd('ok');
        $categories = allowances::onlyTrashed()->get();
        // return $allowances;

        return view('admin.Employee.Achive.allowances.allowances', compact('categories'));
        
       
    } //end of allowanceshistoryData
    public function allowancesAchive(Request $request)
    {
        $str = '';
        $query = allowances::query()->onlyTrashed();
        return  DataTables::of($query)
            ->editColumn(
                'actions',
                'admin.Employee.Achive.allowances.data_table.actions'
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
    } //end of allowanceshistoryData

    public function allowancesAchiveFeedback(Request $request, $id)
    {
        // $id = $request->invoice_id;
        $flight = allowances::withTrashed()->where('id', $id)->restore();
        session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('Achive.allowances.Achive');
        
       
    } //end of SectionhistoryData





       public function Achive_employee(Request $request)
    {

        // dd('ok');
        $categories = employee::onlyTrashed()->get();
        // return $employee;

        return view('admin.Employee.Achive.employee.employee', compact('categories'));
        
       
    } //end of employeehistoryData
    public function employeeAchive(Request $request)
    {
        $str = '';
        $query = employee::query()->onlyTrashed();
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
                'admin.Employee.Achive.employee.data_table.actions'
            )
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
    } //end of employeehistoryData

    public function employeeAchiveFeedback(Request $request, $id)
    {
        // $id = $request->invoice_id;
        $flight = employee::withTrashed()->where('id', $id)->restore();
        $flight = employee_allowances::withTrashed()->where([['employee_id', $id],['status', 1]])->restore();
        session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('Achive.employee.Achive');
        
       
    } //end of SectionhistoryData


    
    public function Achive_employee_allowances(Request $request)
    {

        // dd('ok');
        $categories = employee_allowances::onlyTrashed()->get();
        // return $employee_allowances;

        return view('admin.Employee.Achive.employee_allowances.employee_allowances', compact('categories'));
        
       
    } //end of employee_allowanceshistoryData
    public function employee_allowancesAchive(Request $request)
    {
        $str = '';
        $query = employee_allowances::query()->where('status', 0)->onlyTrashed();
        return  DataTables::of($query)
            ->editColumn(
                'actions',
                'admin.Employee.Achive.employee_allowances.data_table.actions'
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

    public function employee_allowancesAchiveFeedback(Request $request, $id)
    {
        $flight = employee_allowances::withTrashed()->where('id', $id)->restore();
        $employee_allow = employee_allowances::findOrFail($id);
        $res = FinancialTreasuryTransactionHistorys::MakeTransacaion($employee_allow->Allowances_id->allowances_value , 'incentives', $employee_allow->employee->name . '-'.$employee_allow->Allowances_id->allowances_name , $employee_allow->id);
        
        session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('Achive.employee_allowances.Achive');
        
       
    } //end of SectionhistoryData



    public function Achive_Advances(Request $request)
    {

        // dd('ok');
       
        // return $Advances;

        return view('admin.Employee.Achive.Advances.Advances');
        
       
    } //end of AdvanceshistoryData
    public function AdvancesAchive(Request $request)
    {
        $str = '';
        $query = Advances::query()->onlyTrashed();
        return  DataTables::of($query)
            ->editColumn(
                'actions',
                'admin.Employee.Achive.Advances.data_table.actions'
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

    public function AdvancesAchiveFeedback(Request $request, $id)
    {
        // return $id;
        $flight = Advances::withTrashed()->where('id', $id)->restore();
        $advances = Advances::findOrFail($id);
        $res = FinancialTreasuryTransactionHistorys::MakeTransacaion( $advances->advances_value, 'advance', $advances->employee->name .'-'.__('translation.Add_Advances') , $advances->id);

        session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('Achive.Advances.Achive');
        
       
    } //end of SectionhistoryData



    public function Achive_salaries(Request $request)
    {

        // dd('ok');
       
        // return $salaries;

        return view('admin.Employee.Achive.salaries.salaries');
        
       
    } //end of salarieshistoryData
    public function salariesAchive(Request $request)
    {
        $str = '';
        $query = salaries::query()->onlyTrashed();;
        return  DataTables::of($query)
            ->editColumn(
                'actions',
               
                'admin.Employee.Achive.salaries.data_table.actions'
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

    public function salariesAchiveFeedback(Request $request, $id)
    {
        // $id = $request->invoice_id;
        $flight = salaries::withTrashed()->where('id', $id)->restore();
        $salaries = salaries::findOrFail($id);
        $res = FinancialTreasuryTransactionHistorys::MakeTransacaion($salaries->totle_salaries, 'salries', $salaries->employee->name . '-' . __('translation.add_salaries'), $salaries->id);

        session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('Achive.salaries.Achive');
        
       
    } //end of SectionhistoryData



}//end of controller
