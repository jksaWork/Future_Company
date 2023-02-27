<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\employee;
use App\Models\section;
use Yajra\DataTables\Facades\DataTables;

// use App\Http\Requests\Request;
use Illuminate\Http\Request;
use Exception;

class DataController extends Controller
{


    public function SectionhistoryData(Request $request)
    {


        $query = section::with('section_name')->where('type' , 'section_name');
        return  DataTables::of($query)
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })



            ->editColumn('section_name', function ($item) {
                return  $item->CurrentOwner[0]->section_name;
            })
            ->editColumn('section_name', fn ($item) => $item->section_name ?? '')
            ->editColumn(
                'actions',
                'admin.Employee.section.data_table.actions'
            )
            ->rawColumns(['actions', 'section_name', 'description'])
            ->toJson();



    } //end of SectionhistoryData


    public function index(Request $request)
    {

        // $Advances = Advances::all();

        return view('admin.Employee.Advances.index', compact('Advances'));
    } //end of index


    public function create()
    {
        return view('admin.Employee.Advances.create', compact('Category'));
    } //end of create


    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'advances_value' => 'required|numeric',
            'month_number' => 'required',
        ]);

        try {
            // // Advances::create([
            //     'employee_id' => $request->employee_id,
            //     'advances_value' => $request->advances_value,
            //     'month_number' => $request->month_number,

            // ]);
            //    return  $DATA;
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('Employee.Advances.index');
        } catch (Exception $e) {
            dd($e);
            session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }
    } //end of store


    public function show($id)
    {

        $employees = employee::findorfail($id);
        // return $employees;
        return view('admin.Employee.Advances.create',compact('employees'));
    }


    public function edit(Request $request, $id)
    {
// return $id;
        // $Advancess = Advances::find($id);
        return view('admin.Employee.Advances.edit', compact( 'Advancess'));
    } //end of edit

    public function update(Request $request, Employee $employee)
    {
        // return $request;
        try{

            $request->validate([
                'employee_id' => 'required',
                'advances_value' => 'required|numeric',
                'month_number' => 'required',
            ]);
        // $Advancess = Advances::findOrFail($request->pro_id);

        // $Advancess->update([
        //     'employee_id' => $request->employee_id,
        //     'advances_value' => $request->advances_value,
        //     'month_number' => $request->month_number,
        // ]);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('Employee.Advances.index');
        }catch(Exception $e){
            dd($e);
            session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }

    } //end of update

    public function destroy( Request $request , $id)
    {
        // return $id;
        // $Advances = Advances::findOrFail($id);
        // $Advances->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('Employee.Advances.index');
    } //end of destroy



}//end of controller
