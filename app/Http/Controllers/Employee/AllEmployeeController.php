<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\Category;
use App\Models\allowances;
use App\Models\Image;
use App\Models\employee_allowances;
use App\Models\Advances;
use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

use function PHPUnit\Framework\returnSelf;

class AllEmployeeController extends Controller
{

    public function index(Request $request)
    {
        $Categorys = Category::all();
        $employees = employee::all();
        $allowns = employee_allowances::where('status', 1)->get();

        return view('admin.Employee.All_Employee.index', compact('employees', 'Categorys','allowns'));
    } //end of index


    public function create()
    {
        $allowances = allowances::where('status', 1)->get();
        // return  $allowances;
        $Category = Category::all();
        return view('admin.Employee.All_Employee.create', compact('Category', 'allowances'));
    } //end of create


    public function store(EmployeeRequest $request)
    {
        // return $request->data;
        try {

            $data = employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'month_number' => Carbon::now(),
                'address' => $request->address,
                'salary' => $request->salary,
                'categories_id' => $request->categories_id,
                'status' => $request->status,
                'description' => $request->description,
            ]);
            // return $data->id;
            $allowances_prvent =  collect($request->data);
            foreach ($allowances_prvent as $allowances) {
                // return $allowances;
                employee_allowances::create([

                    'employee_id' => $data->id,
                    'status' => 1,
                    'month_number' => Carbon::now(),
                    'allowances_id' => $allowances,
                ]);
            }
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('Employee.All_Employee.index');
        } catch (Exception $e) {
            dd($e);
            session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }
    } //end of store


    public function show($id)
    {
        // return $id;
        $images = Image::all();
        // return $images;

        $allowances_id = employee_allowances::where('employee_id', [$id])->get();
        // return $allowances_id;
        $Advances_id = Advances::where('employee_id', [$id])->get();
        // return $Advances_id;
        $employees = employee::findorfail($id);
        return view('admin.Employee.All_Employee.show', compact('employees', 'images', 'Advances_id', 'allowances_id'));
    }


    public function edit(employee $employee, $id)
    {
        $Categorys = Category::all();
        // return $Categorys;
        $employees = employee::find($id);
        $d = 1;
        $employee_allowances = employee_allowances::where([
            ['status', $d],
            ['employee_id',  $id],
        ])->get();

        $allowns = employee_allowances::where([
            ['status', $d],
            ['employee_id',  $id],
        ])->get(['allowances_id']);
        $allowanceses = allowances::where('status', $d)->whereNotIn('id', $allowns)->get();

        return view('admin.Employee.All_Employee.edit', compact('Categorys', 'employees', 'employee_allowances', 'allowanceses'));
    } //end of edit

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        // return $request;
        try {

            $id = Category::where('categories_name', $request->categories_id)->first()->id;

            // return $allowances_prvent;
            $employee = employee::findOrFail($request->pro_id);

            $employee->update([
                'name' => $request->name,
                'email' => $request->email,
                'description' => $request->description,
                'month_number' => Carbon::now(),
                'phone' => $request->phone,
                'address' => $request->address,
                'salary' => $request->salary,
                'categories_id' => $id,
                'status' => $request->status,
                'description' => $request->description,
            ]);

            $allowances_prvent =  collect($request->data);

            if (!$allowances_prvent) {

                foreach ($allowances_prvent as $allowances) {

                    employee_allowances::create([
                        'employee_id' => $request->pro_id,
                        'status' => 1,
                        'month_number' => Carbon::now(),
                        'allowances_id' => $allowances,
                    ]);
                }
            }
            session()->flash('success', __('site.updated_successfully'));
            return redirect()->route('Employee.All_Employee.index');
        } catch (Exception $e) {
            dd($e);
            session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }
    } //end of update

    public function destroy(Employee $employee, $id)
    {
        // return $id;
        $employee = employee::findOrFail($id);
        $employee_allowances = employee_allowances::where([
            ['status', 1],
            ['employee_id',  $id],
        ])->get();
        $employee->delete();
        $employee_allowances->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('Employee.All_Employee.index');
    } //end of destroy



}//end of controller
