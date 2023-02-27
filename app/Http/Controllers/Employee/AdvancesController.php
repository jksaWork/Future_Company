<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\Advances;
use App\Models\FinancialTreasuryTransactionHistorys;
// use App\Http\Requests\Request;
use Illuminate\Http\Request;
use Exception;

class AdvancesController extends Controller
{

    public function index(Request $request)
    {

        $Advances = Advances::all();

        return view('admin.Employee.Advances.index', compact('Advances'));
    } //end of index


    public function create()
    {
        return view('admin.Employee.Advances.create', compact('Category'));
    } //end of create


    public function store(Request $request)
    {
        // return  $request;

        try {
            $employee = employee::select('name')->findOrFail($request->employee_id);
            // $employee = Advances::select('name')->findOrFail($request->employee_id);
            $advance = Advances::create([
                'employee_id' => $request->employee_id,
                'advances_value' => $request->advances_value,
                'advances_Date' => $request->advances_Date,
            ]);

            FinancialTreasuryTransactionHistorys::MakeTransacaion($request->advances_value, 'advance', __('translation.employee_advances')  . ' - ' . $employee->name, $advance->id);

            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route('Employee.Advances.index');
        } catch (Exception $e) {
            dd($e);
            session()->flash('error',  'Some Thing Went Worng ');
            return redirect()->back();
        }
    } //end of store


    public function show($id)
    {

        $employees = employee::findorfail($id);
        // return $employees;
        return view('admin.Employee.Advances.create', compact('employees'));
    }


    public function edit(Request $request, $id)
    {
        // return $id;
        $Advancess = Advances::find($id);
        return view('admin.Employee.Advances.edit', compact('Advancess'));
    } //end of edit

    public function update(Request $request, Employee $employee)
    {
        // return $request;
        try {

            // $id = Category::where('categories_name', $request->categories_id)->first()->id;
            //    return $id;
            $Advancess = Advances::findOrFail($request->pro_id);

            $Advancess->update([
                'employee_id' => $request->employee_id,
                'advances_value' => $request->advances_value,
                'advances_Date' => $request->advances_Date,
            ]);
            session()->flash('success', __('site.deleted_successfully'));
            return redirect()->route('Employee.Advances.index');
        } catch (Exception $e) {
            dd($e);
            session()->flash('error',  'Some Thing Went Worng ');
            return redirect()->back();
        }
    } //end of update

    public function destroy(Request $request, $id)
    {
        // return $id;
        $Advances = Advances::findOrFail($id);
        $Advances->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('Employee.Advances.index');
    } //end of destroy



}//end of controller