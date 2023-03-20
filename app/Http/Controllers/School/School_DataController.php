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
use Illuminate\Http\Request;
use Exception;

use function PHPUnit\Framework\returnSelf;

class School_DataController extends Controller
{


    public function school_typeshistoryData(Request $request)
    {


        $query = school_types::query();
        return  DataTables::of($query)->editColumn(
            'actions',
            'admin.School_teachers.school_type.data_table.actions'
        )
            ->rawColumns(['actions'])
            ->toJson();
    } //end of SectionhistoryData

    public function SectionhistoryData(Request $request)
    {
        // return $request;
        if (request()->section == null) {
            $query = school_sections::query();
        } else {
            $query = school_sections::query()->where('school_id', request()->section)->get(); # code...
        }

        return  DataTables::of($query)



            ->editColumn(
                'actions',
                'admin.School_teachers.School_section.data_table.actions'
            )

            ->editColumn('school_id', function ($item) {
                return "<span class='badge badge-success'>" . $item->school->school_name . "</span>";
            })

            ->rawColumns(['actions', 'school_id'])
            ->toJson();
    } //end of spendinghistoryData
    public function spendinghistoryData(Request $request)
    {

        if (request()->school_spendings == null) {
            $query = school_spendings::query();
        } else {
            $query = school_spendings::query()->where('school_id', request()->school_spendings)->get(); # code...
        }

        // $query = school_spendings::query();
        return  DataTables::of($query)->editColumn(
            'actions',
            'admin.School_teachers.School_spending.data_table.actions'
        )
            ->editColumn('school_id', function ($item) {
                return "<span class='badge badge-success'>" . $item->school->school_name . "</span>";
            })
            ->editColumn('section_id', function ($item) {
                return "<span class='badge badge-primary'>" . $item->section->section_name . "</span>";
            })
            ->editColumn('spending_value', function ($item) {
                return number_format($item->spending_value, 2);
            })
            ->rawColumns(['actions', 'school_id', 'section_id', 'spending_value'])
            ->toJson();
    } //end of CategoryhistoryData

    public function CategoryhistoryData(Request $request)
    {
        if (request()->school_categories == null) {
            $query = school_categories::query();
        } else {
            $query = school_categories::query()->where('school_id', request()->school_categories)->get(); # code...
        }
        // $query = school_categories::query();
        return  DataTables::of($query)->editColumn(
            'actions',
            'admin.School_teachers.School_categories.data_table.actions'
        )

            ->editColumn('school_id', function ($item) {
                return "<span class='badge badge-success'>" . $item->school->school_name . "</span>";
            })

            ->rawColumns(['actions', 'school_id'])
            ->toJson();
    }

    public function allowanceshistoryData(Request $request)
    {
        $str = '';
        if (request()->School_allowances == null) {
            $query = School_allowances::query();
        } else {
            $query = School_allowances::query()->where('school_id', request()->School_allowances)->get(); # code...
        }
        // $query = School_allowances::query();
        return  DataTables::of($query)
            ->editColumn(
                'actions',
                'admin.School_teachers.School_allowances.data_table.actions'
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
            ->editColumn('school_id', function ($item) {
                return "<span class='badge badge-primary'>" . $item->school->school_name . "</span>";
            })

            ->rawColumns(['actions', 'allowances_value', 'created_at', 'status', 'school_id'])
            ->toJson();
    } //end of salarieshistoryData

    public function teachershistoryData(Request $request)
    {
        $str = '';
        if (request()->school_teachers == null) {
            $query = school_teachers::query();
        } else {
            $query = school_teachers::query()->where('school_id', request()->school_teachers)->get(); # code...
        }
        // $query = school_teachers::query();
        return  DataTables::of($query)


            ->editColumn(
                'actions',
                'admin.School_teachers.School_teachers.data_table.actions'
            )
            ->addColumn('allowances_id', function ($item) use ($str) {
                $allowancesS = School_Teachers_allowances::where(['teachers_id' => $item->id,  'status' => 1])->get();
                foreach ($allowancesS as $key => $allowances) {
                    $str .= "<span class='badge badge-light-info'>" . $allowances->Allowances_id->allowances_name . ' ( ' . $allowances->Allowances_id->allowances_value  . ' ) ' . '</span>';
                }
                // DD($str);
                return $str;
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

            ->rawColumns(['actions', 'categories_id', 'status', 'allowances_id', 'school_id'])
            ->toJson();
    } //end of employeeshistoryData




    public function teachers_allowanceshistoryData(Request $request)
    {
        $str = '';
        if (request()->school_teachers_allowances == null) {
            $query = school_teachers_allowances::query()->where('status', 0);
        } else {
            $query = school_teachers_allowances::query()->where([['school_id', request()->school_teachers_allowances],['status', 0]])->get(); # code...
        }
        // $query = school_teachers_allowances::query()->where('status', 0);
        return  DataTables::of($query)
            ->editColumn(
                'actions',
                'admin.School_teachers.School_teachers_allowances.data_table.actions'
            )
            ->editColumn('teachers_id', function ($item) {
                return  $item->teachers->name;
            })
            ->editColumn('allowances_id', function ($item) {
                return "<span class='badge badge-light-info'>" . $item->Allowances_id->allowances_name . ' ( ' . $item->Allowances_id->allowances_value  . ' ) ' . '</span>';
            })

            ->editColumn('school_id', function ($item) {
                return "<span class='badge badge-primary'>" . $item->school->school_name . "</span>";
            })

            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })

            ->rawColumns(['actions', 'teachers_id', 'allowances_id', 'created_at', 'school_id'])
            ->toJson();
    } //end of employee_allowanceshistoryData
    public function AdvanceshistoryData(Request $request)
    {
        if (request()->school_advances == null) {
            $query = school_advances::query();
        } else {
            $query = school_advances::query()->where('school_id', request()->school_advances)->get(); # code...
        }
        $str = '';
        // $query = school_advances::query();
        return  DataTables::of($query)
            ->editColumn(
                'actions',
                'admin.School_teachers.School_Advances.data_table.actions'
            )
            ->editColumn('teachers_id', function ($item) {
                return  $item->teachers->name;
            })
            ->editColumn('advances_value', function ($item) {
                return number_format($item->advances_value, 2);
            })

            ->editColumn('school_id', function ($item) {
                return "<span class='badge badge-primary'>" . $item->school->school_name . "</span>";
            })
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })

            ->rawColumns(['actions', 'teachers_id', 'created_at', 'advances_value', 'school_id'])
            ->toJson();
    } //end of AdvanceshistoryData

    public function salarieshistoryData(Request $request)
    {
        if (request()->School_salaries == null) {
            $query = School_salaries::query();
        } else {
            $query = School_salaries::query()->where('school_id', request()->School_salaries)->get(); # code...
        }
        $str = '';
        // $query = School_salaries::query();
        return  DataTables::of($query)
            ->editColumn(
                'actions',
                'admin.School_teachers.School_salaries.data_table.actions'
            )
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

            ->rawColumns(['actions', 'teachers_id', 'created_at', 'status', 'school_id'])
            ->toJson();
    } //end of salarieshistoryData



    public function ChangeStatus($id)
    {
        $employee = school_teachers::findOrFail($id);
        $employee->ChangeStatus();
        return redirect()->back();
    }
}//end of controller
