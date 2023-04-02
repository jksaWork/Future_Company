<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\school_teachers;
use App\Models\school_categories;
use App\Models\School_allowances;
use App\Models\school_images;
use App\Models\school_teachers_allowances;
use App\Models\school_advances;
use App\Models\school_salaries;
use App\Models\school_types;
use App\Http\Requests\SchooleRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

use function PHPUnit\Framework\returnSelf;

class School_AllteachersController extends Controller
{

    public function index(Request $request)
    {
        $school_id =school_types::all();
        return view('admin.School_teachers.School_teachers.index', compact('school_id'));
    } //end of index


    public function create()
    {
        // return 1;
        $school_id =school_types::all();
        $allowances = School_allowances::where('status', 1)->get();
        // return  $allowances;
        $Category = school_categories::all();
        return view('admin.School_teachers.School_teachers.create', compact('Category', 'allowances','school_id'));
    } //end of create


    public function store(Request $request)
    {
         $request->validate([
            'school_id' =>'required',
            'name' =>'required',
            'email' => 'required|email|unique:School_teachers,email,',
            'phone' =>'required|max:100|unique:School_teachers,phone,',
            'address' =>'required|string|max:500',
            'salary' =>'required|nullable|numeric',
            'categories_id' =>'required|exists:school_categories,id',
            'month'=>'required|date_format:Y-m-d',
            'data'=>'required',
        ]);

       
        try {

            $data = school_teachers::create([
                'name' => $request->name,
                'school_id' => $request->school_id,
                'email' => $request->email,
                'phone' => $request->phone,
                'month_number' => Carbon::now(),
                'address' => $request->address,
                'month' => $request->month,
                'salary' => $request->salary,
                'categories_id' => $request->categories_id,
                'status' => 1,
                'description' => $request->description,
            ]);
            // return $data->id;
            $allowances_prvent =  collect($request->data);
            foreach ($allowances_prvent as $allowances) {
                // return $allowances;
                school_teachers_allowances::create([

                    'teachers_id' => $data->id,
                    'status' => 1,
                    'month_number' => Carbon::now()->month,
                    'year' => Carbon::now()->year,
                    'allowances_id' => $allowances,
                    'school_id' => $request->school_id,
                ]);
            }
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('School.All_Teachers.index');
        } catch (Exception $e) {
            dd($e);
            session()->flash('error',  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }
    } //end of store


    public function show($id)
    {
        // return $id;
        $images = school_images::all();
        // return $images;
        $d = 1;
        $z = 0;
        $employee_allowances = school_teachers_allowances::where([
            ['status', $d],
            ['teachers_id',  $id],
        ])->get();
        // return $employee_allowances;
        $allowances_id = school_teachers_allowances::where([
            ['status', $z],
            ['teachers_id',  $id],
        ])->get();


        $salaries = school_salaries::where([['teachers_id',$id]])->get();
        // return $salaries;
        // return $allowances_id;
        $Advances_id = school_advances::where('teachers_id', [$id])->get();
        // return $Advances_id;
        $employees = school_teachers::findorfail($id);
        return view('admin.School_teachers.School_teachers.show', compact('employees', 'images', 'Advances_id', 'allowances_id', 'employee_allowances', 'salaries'));
    }


    public function edit($id)
    {
        $school_types =school_types::all();
        $Categorys = school_categories::all();
        // return $Categorys;
        $employees = school_teachers::find($id);
        $d = 1;
        $employee_allowances = school_teachers_allowances::where([
            ['status', $d],
            ['teachers_id',  $id],
        ])->get();

        $allowns = school_teachers_allowances::where([
            ['status', $d],
            ['teachers_id',  $id],
        ])->get(['allowances_id']);
        $allowanceses = school_allowances::where('status', $d)->whereNotIn('id', $allowns)->get();

        return view('admin.School_teachers.School_teachers.edit', compact('Categorys', 'employees', 'employee_allowances', 'allowanceses','school_types'));
    } //end of edit

    public function update(Request $request, $id)
    {
        // return $request;
        $request->validate([
            'school_id' =>'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required|string|max:500',
            'salary' => 'required|nullable|numeric',
            'month' => 'required|date_format:Y-m-d',
            'categories_id' => 'required',
            'data' => 'required',
        ]);
        try {
            
            // $school_categories = school_categories::where('categories_name', $request->categories_id)->first()->id;
            // return $school_categories;
            // return $allowances_prvent;
            $employee = school_teachers::findOrFail($id);

            $employee->update([
                'name' => $request->name,
                'school_id' => $request->school_id,
                'email' => $request->email,
                'description' => $request->description,
                'month_number' => Carbon::now(),
                'phone' => $request->phone,
                'address' => $request->address,
                'month' => $request->month,
                'salary' => $request->salary,
                'categories_id' => $request->categories_id,
                'description' => $request->description,
            ]);
            // return $employee;

            $allowances_prvent =  collect($request->data);

            // if (!$allowances_prvent) {

            $allowns = school_teachers_allowances::where([
                ['status', 1],
                ['teachers_id',  $request->pro_id],
            ])->get();
            foreach ($allowns as $key => $value) {
                $employee_allowances = school_teachers_allowances::findOrFail($value->id);
                $employee_allowances->delete();
            }
            // return $allowns;
            foreach ($allowances_prvent as $allowances) {

                school_teachers_allowances::create([
                    'teachers_id' => $request->pro_id,
                    'status' => 1,
                    'month_number' => Carbon::now()->month,
                    'year' => Carbon::now()->year,
                    'allowances_id' => $allowances,
                    'school_id' => $request->school_id,
                ]);
            }
            // }
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('School.All_Teachers.index');
        } catch (Exception $e) {
            dd($e);
            session()->flash('error',  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }
    } //end of update

    public function destroy($id)
    {
        // return $id;
        // $employee = employee::findOrFail($id);
        // $employee_allowances = employee_allowances::where([
        //     ['status', 1],
        //     ['employee_id',  $id],
        // ])->get();
        // foreach ($employee_allowances as $key => $value) {
        //     $employee_allowances = employee_allowances::findOrFail($value->id);
        //     $employee_allowances->delete();
        // }
        // $employee->delete();
        // session()->flash('error', __('site.has_been_transferred_successfully'));
        // return redirect()->route('Employee.All_Employee.index');
    } //end of destroy
    public function categories($id)
    {
        $categories_id = DB::table("school_categories")->where("school_id", $id)->pluck("categories_name", "id");
       
        return json_encode($categories_id);
    }

    public function allowances($id)
    {
        $allowances = DB::table("school_allowances")->where([["school_id", $id],['status' , 1],['deleted_at' ,NULL]])->pluck("allowances_name", "id");
       
        return json_encode($allowances);
    }






}//end of controller