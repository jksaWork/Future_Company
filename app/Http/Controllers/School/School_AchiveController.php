<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\School_allowances;
use App\Models\school_salaries;
use App\Models\school_teachers;
use App\Models\school_advances;
use App\Models\school_types;
use App\Models\school_sections;
use App\Models\school_spendings;
use App\Models\school_categories;
use App\Models\school_teachers_allowances;
use App\Models\SchoolTreasuryTransactionHistory;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
// use App\Http\Requests\Request;
use Illuminate\Http\Request;
use Exception;
use PhpParser\Node\Stmt\Return_;

class School_AchiveController extends Controller
{


    public function Achive_section(Request $request)
    {

        // dd('ok');
        $section = school_sections::onlyTrashed()->get();
        // return $section;

        return view('admin.School_teachers.School_Achive.Expense_sections.section', compact('section'));
        
       
    } //end of SectionhistoryData
    public function SectionAchive(Request $request)
    {


        $query = school_sections::query()->onlyTrashed();
        return  DataTables::of($query)
        ->editColumn(
            'actions',
            'admin.School_teachers.School_Achive.Expense_sections.data_table.actions'
        )
            ->rawColumns(['actions'])
            ->toJson();
    } //end of SectionhistoryData

    public function SectionAchiveFeedback(Request $request, $id)
    {
        // $id = $request->invoice_id;
        $flight = school_sections::withTrashed()->where('id', $id)->restore();
        session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('Achive.section.Achive');
        
       
    } //end of SectionhistoryData




    public function Achive_spending(Request $request)
    {

        // dd('ok');
        $spending = school_spendings::onlyTrashed()->get();
        // return $spending;

        return view('admin.School_teachers.School_Achive.spending.spending', compact('spending'));
        
       
    } //end of spendinghistoryData
    public function spendingAchive(Request $request)
    {
        $query = school_spendings::query()->onlyTrashed();
        return  DataTables::of($query)->editColumn(
            'actions',
            'admin.School_teachers.School_Achive.spending.data_table.actions'
        )
        
        ->editColumn('section_id', function ($item) {
            return "<span class='badge badge-success'>" . $item->section->section_name . "</span>";
        })
            ->editColumn('spending_value', function ($item) {
                return number_format($item->spending_value, 2);
            })
            ->editColumn('school_id', function ($item) {
                return "<span class='badge badge-success'>" . $item->school->school_name . "</span>";
            })
            ->rawColumns(['actions', 'section_id','school_id'])
            ->toJson();
    } //end of spendinghistoryData

    public function spendingAchiveFeedback(Request $request, $id)
    {
    try{
        $flight = school_spendings::withTrashed()->where('id', $id)->restore();
        $spending = school_spendings::findOrFail($id);
        $res = SchoolTreasuryTransactionHistory::MakeTransacaion($spending->spending_value, 'spending', $spending->spending_name . '-' . $spending->School->school_name, $spending->id);
        // $res = SchoolTreasuryTransactionHistory::MakeTransacaion($spending->Allowances_id->allowances_value , 'incentives', $spending->employee->name . '-'.$spending->Allowances_id->allowances_name , $spending->id);
        $spending->update([
            'Transaction_id' => $res->id,
        ]);
         session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('School_Achive.School_spending.Achive');
    } catch (Exception $e) {
        dd($e);
        // if ($e->getCode() == 51) {
        //     DB::commit();
        //     session()->flash('success', __('site.updated_successfully'));
        //     return redirect()->back()->withErrors(__('translation.' . $e->getMessage()))->withInput();
        //     // if ($e->getCode() == 50)   session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
        // }
        
        if ($e->getCode() == 50) {
            DB::commit();  
            session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
            return redirect()->back();
        }
        DB::rollBack();
        session()->flash('error',  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }
   

       
    } //end of SectionhistoryData

  

    public function Achive_Category(Request $request)
    {

        // dd('ok');
        $categories = school_categories::onlyTrashed()->get();
        // return $Category;

        return view('admin.School_teachers.School_Achive.Category.Category', compact('categories'));
        
       
    } //end of CategoryhistoryData
    public function CategoryAchive(Request $request)
    {
        $query = school_categories::query()->onlyTrashed();
        return  DataTables::of($query)->editColumn(
            'actions',
            'admin.School_teachers.School_Achive.Category.data_table.actions'
        )

            ->rawColumns(['actions'])
            ->toJson();
    } //end of CategoryhistoryData

    public function CategoryAchiveFeedback(Request $request, $id)
    {
        // $id = $request->invoice_id;
        $flight = school_categories::withTrashed()->where('id', $id)->restore();
        session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('Achive.Category.Achive');
        
       
    } //end of SectionhistoryData


    public function Achive_allowances(Request $request)
    {

        // dd('ok');
        $categories = School_allowances::onlyTrashed()->get();
        // return $allowances;

        return view('admin.School_teachers.School_Achive.allowances.allowances', compact('categories'));
   
        
       
    } //end of allowanceshistoryData
    public function allowancesAchive(Request $request)
    {
        $str = '';
        $query = School_allowances::query()->onlyTrashed();
        return  DataTables::of($query)
            ->editColumn(
                'actions',
                'admin.School_teachers.School_Achive.allowances.data_table.actions'
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
            ->editColumn('school_id', function ($item) {
                return "<span class='badge badge-success'>" . $item->School->school_name . "</span>";
            })

            ->rawColumns(['actions', 'allowances_value', 'created_at','status','school_id'])
            ->toJson();
    } //end of allowanceshistoryData

    public function allowancesAchiveFeedback(Request $request, $id)
    {
        try{
        // $id = $request->invoice_id;
        $flight = School_allowances::withTrashed()->where('id', $id)->restore();
        session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('School_Achive.School_allowances.Achive');

    } catch (Exception $e) {
        if ($e->getCode() == 50) {
            DB::commit();  
            session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
            return redirect()->back();
        }
        DB::rollBack();
        session()->flash('error',  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }
        
       
    } //end of SectionhistoryData





       public function Achive_employee(Request $request)
    {

        // dd('ok');
        $categories = school_teachers::onlyTrashed()->get();
        // return $employee;

        return view('admin.School_teachers.School_Achive.employee.employee', compact('categories'));
        
       
    } //end of employeehistoryData
    public function employeeAchive(Request $request)
    {
        $str = '';
        $query = school_teachers::query()->onlyTrashed();
        return  DataTables::of($query)
            ->addColumn('allowances_id', function ($item) use ($str) {
                $allowancesS = school_teachers_allowances::where(['employee_id' => $item->id,  'status' => 1])->get();
                foreach ($allowancesS as $key => $allowances) {
                    $str .= "<span class='badge badge-light-info'>" . $allowances->Allowances_id->allowances_name . ' ( ' . $allowances->Allowances_id->allowances_value  . ' ) ' . '</span>';
                }
                // DD($str);
                return $str;
            })
            ->editColumn(
                'actions',
                'admin.School_teachers.School_Achive.employee.data_table.actions'
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
        $flight = school_teachers::withTrashed()->where('id', $id)->restore();
        $flight = school_teachers_allowances::withTrashed()->where([['employee_id', $id],['status', 1]])->restore();
        session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('Achive.employee.Achive');
        
       
    } //end of SectionhistoryData


    
    public function Achive_employee_allowances(Request $request)
    {

        // dd('ok');
        $categories = school_teachers_allowances::onlyTrashed()->get();
        // return $employee_allowances;

        return view('admin.School_teachers.School_Achive.employee_allowances.employee_allowances', compact('categories'));
        
       
    } //end of employee_allowanceshistoryData
    public function employee_allowancesAchive(Request $request)
    {
        $str = '';
        $query = School_Teachers_allowances::query()->where('status', 0)->onlyTrashed();
        return  DataTables::of($query)
            ->editColumn(
                'actions',
                'admin.School_teachers.School_Achive.employee_allowances.data_table.actions'
            )
            ->editColumn('teachers_id', function ($item) {
                return  $item->teachers->name;
            })
            ->editColumn('allowances_id', function ($item) {
                return "<span class='badge badge-light-info'>". $item->Allowances_id->allowances_name . ' ( ' . $item->Allowances_id->allowances_value  . ' ) ' . '</span>';
            })

            ->editColumn('school_id', function ($item) {
                return "<span class='badge badge-success'>" . $item->school->school_name . "</span>";
            })
            
            ->editColumn('created_at', function ($item) { 
                return $item->created_at->format('Y-m-d');
            })

            ->rawColumns(['actions', 'teachers_id', 'allowances_id' , 'created_at','school_id'])
            ->toJson();
    } //end of employee_allowanceshistoryData

    public function employee_allowancesAchiveFeedback(Request $request, $id)
    {
        try{
        $flight = School_Teachers_allowances::withTrashed()->where('id', $id)->restore();
        $employee_allow = School_Teachers_allowances::findOrFail($id);
        $res = SchoolTreasuryTransactionHistory::MakeTransacaion($employee_allow->Allowances_id->allowances_value , 'incentives', $employee_allow->employee->name . '-'.$employee_allow->School->school_name , $employee_allow->id);
        $employee_allow->update([
            'Transaction_id' => $res->id,
        ]);
        session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('School_Achive.School_employee_allowances.Achive');
    } catch (Exception $e) {
        if ($e->getCode() == 50) {
            DB::commit();  
            session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
            return redirect()->back();
        }
        DB::rollBack();
        session()->flash('error',  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }
        
       
    } //end of SectionhistoryData



    public function Achive_Advances(Request $request)
    {

        // dd('ok');
       
        // return $Advances;

        return view('admin.School_teachers.School_Achive.Advances.Advances');
        
       
    } //end of AdvanceshistoryData
    public function AdvancesAchive(Request $request)
    {
        $str = '';
        $query = school_advances::query()->onlyTrashed();
        return  DataTables::of($query)
            ->editColumn(
                'actions',
                'admin.School_teachers.School_Achive.Advances.data_table.actions'
            )
            ->editColumn('teachers_id', function ($item) {
                return  $item->teachers->name;
            })
            ->editColumn('advances_value', function ($item) {
                return number_format($item->advances_value, 2) ;
            })
            ->editColumn('school_id', function ($item) {
                return "<span class='badge badge-success'>" . $item->school->school_name . "</span>";
            })

            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })

            ->rawColumns(['actions', 'teachers_id', 'created_at', 'school_advances_value','school_id'])
            ->toJson();
    } //end of school_advanceshistoryData

    public function AdvancesAchiveFeedback(Request $request, $id)
    {
        // return $id;
        try{
        $flight = school_advances::withTrashed()->where('id', $id)->restore();
        $advances = school_advances::findOrFail($id);
        $res = SchoolTreasuryTransactionHistory::MakeTransacaion( $advances->advances_value, 'advance', $advances->teachers->name .'-'.$advances->School->school_name , $advances->id);
        $advances->update([
            'Transaction_id' => $res->id,
        ]);
        session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('School_Achive.School_Advances.Achive');
    } catch (Exception $e) {
        dd($e);
        if ($e->getCode() == 50) {
            DB::commit();  
            session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
            return redirect()->back();
        }
        DB::rollBack();
        session()->flash('error',  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }
        
       
    } //end of SectionhistoryData



    public function Achive_salaries(Request $request)
    {

        // dd('ok');
       
        // return $salaries;

        return view('admin.School_teachers.School_Achive.salaries.salaries');
        
       
    } //end of salarieshistoryData
    public function salariesAchive(Request $request)
    {
        $str = '';
        $query = school_salaries::query()->onlyTrashed();;
        return  DataTables::of($query)
            ->editColumn(
                'actions',
               
                'admin.School_teachers.School_Achive.salaries.data_table.actions'
            )
            ->editColumn('teachers_id', function ($item) {
                return  $item->teachers->name;
            })
             ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->editColumn('school_id', function ($item) {
                return "<span class='badge badge-success'>" . $item->school->school_name . "</span>";
            })
            ->editColumn('status', function ($item) {
                return "<span class='badge badge-success'>". $item->getActive() .'</span>';
            })

            ->rawColumns(['actions', 'teachers_id', 'created_at','status','school_id'])
            ->toJson();
    } //end of salarieshistoryData

    public function salariesAchiveFeedback(Request $request, $id)
    {
        try{
        // $id = $request->invoice_id;
        $flight = school_salaries::withTrashed()->where('id', $id)->restore();
        $salaries = school_salaries::findOrFail($id);
        $res = SchoolTreasuryTransactionHistory::MakeTransacaion($salaries->totle_salaries, 'salries', $salaries->teachers->name . '-' . $salaries->School->school_name, $salaries->id);
        $salaries->update([
            'Transaction_id' => $res->id,
        ]);
        DB::commit();
        session()->flash('success', __('site.recovery_successfully'));
        return redirect()->route('School_Achive.School_salaries.Achive');
    } catch (Exception $e) {
        dd($e);
        if ($e->getCode() == 50) {
            DB::commit();  
            session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
            return redirect()->back();
        }
        DB::rollBack();
        session()->flash('error',  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }
        
       
    } //end of SectionhistoryData



}//end of controller
