<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use App\Models\Owner;
use App\Models\school_types;
use App\Models\SchoolTreasuryTransactionHistory;
use App\Models\StudentRevenue;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use DB;

class StudentRevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $headings = [
            'student_revenues' => __('translation.student_renvue'),
            'transfer_renvue' => __('translation.transfer_renvue')
        ];

        return view('school.students.index', compact('headings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $headings = [
            'student_revenues' => __('translation.student_renvue'),
            'transfer_renvue' => __('translation.transfer_renvue')
        ];
        $schooles = school_types::get();
        return view('school.students.create', compact('headings', 'schooles'));
    }

    public function data()
    {
        $query = StudentRevenue::query() #  TODO: With('Category')
            ->typeScope()
            ->where('deleted_at', null);
        // dd('jksa');
        return  DataTables::of($query)
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })

            ->editColumn('amount', function ($item) {
                return number_format($item->amount, 2);
            })
            ->editColumn('school_id', function ($item) {
                return $item->School->school_name;
            })
            ->editColumn('revenue_type', function ($item) {
                return __('translation.' . $item->revenue_type);
            })
            ->editColumn('opration_type', function ($item) {
                return __('translation.' . $item->opration_type);
            })
            ->editColumn(
                'actions',
                'school.students.data_table.actions'
            )
            ->rawColumns(['actions', 'status', 'is_rent', 'is_sale'])
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        $request->validate([
            'student_name' => 'required',
            'student_guard' => 'required',
            'amount' => 'required|numeric',
            'opration_type' => 'required',
            'school_idd' => 'required',
            'type_id' => 'required',
            // 'opration_idd' => 'required_if'
        ]);

        try {
            // return $request;
            DB::beginTransaction();
            $data = [
                'student_name' => $request->student_name,
                'student_guard' => $request->student_guard,
                'amount' => $request->amount,
                'opration_type' => $request->opration_type,
                'school_id' => $request->school_idd,
                'revenue_type' => $request->type_id,
                'recept_date' => $request->recept_date ?? date('y-m-d'),
                'opration_id' => $request->opration_idd,

            ];
            $renvue = StudentRevenue::create($data);

            // Upload Files
            if ($request->hasFile('payment_attachment')) {
                Attachments::AttachMUltiFIleFiles([$request->payment_attachment], $renvue, 'revenue/attachments');
                // dd('Done');
            }

            // return $request;
            $transaaction = SchoolTreasuryTransactionHistory::MakeTransacaion(
                $request->amount,
                $request->type_id,
                __('translation.recept_revenues') . $request->student_name,
                $request->school_idd,
                $renvue->id
            );
            $renvue->transaction_id = $transaaction->id;
            $renvue->save();


            session()->flash('success', __('translation.recept_revenues_success_fule'));
            DB::commit();
            return redirect()->route('school.students.revenues.index', ['type' => $request->type_id]);
        } catch (\Throwable $e) {

            if ($e->getCode() == 51) {
                DB::commit();
                session()->flash('success', __('site.added_successfully'));
                return redirect()->back()->withErrors(__('translation.' . $e->getMessage()))->withInput();
                // if ($e->getCode() == 50)   session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
            }
            // dd($th);
            DB::rollback();
            return  redirect()->back()->withErrors(__('translation.6'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentRevenue  $studentRevenue
     * @return \Illuminate\Http\Response
     */
    public function show($studentRevenue)
    {
        $studentRevenue = StudentRevenue::findOrFail($studentRevenue);
        return view('school.students.show', compact('studentRevenue'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentRevenue  $studentRevenue
     * @return \Illuminate\Http\Response
     */
    public function edit($studentRevenue)
    {
        $studentRevenue = StudentRevenue::findOrFail($studentRevenue);
        $headings = [
            'student_revenues' => __('translation.student_renvue'),
            'transfer_renvue' => __('translation.transfer_renvue')
        ];
        $schooles = school_types::get();
        return view('school.students.edit', compact('headings', 'schooles', 'studentRevenue'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentRevenue  $studentRevenue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $studentRevenue)
    {
        // return $request;
        $studentRevenue = StudentRevenue::findOrFail($studentRevenue);
        $request->validate([
            'student_name' => 'required',
            'student_guard' => 'required',
            'amount' => 'required|numeric',
            'opration_type' => 'required',
            'school_idd' => 'required',
            'type_id' => 'required',
            // 'opration_idd' => 'required_if'
        ]);

        try {
            // return $request;
            DB::beginTransaction();
            $data = [
                'student_name' => $request->student_name,
                'student_guard' => $request->student_guard,
                'amount' => $request->amount,
                'opration_type' => $request->opration_type,
                'opration_id' => $request->opration_idd,
                'school_id' => $request->school_idd,
                'revenue_type' => $request->type_id,
                'recept_date' => $request->recept_date ?? date('y-m-d')
            ];
            // Update Data
            $studentRevenue->update($data);

            // return $request;
            SchoolTreasuryTransactionHistory::EditTransaction(
                $studentRevenue->transaction_id,
                $request->amount
            );

            session()->flash('success', __('translation.recept_revenues_success_fule'));
            DB::commit();
            return redirect()->route('school.students.revenues.index', ['type' => $request->type_id]);
        } catch (\Exception $e) {
            if ($e->getCode() == 51) {
                DB::commit();
                session()->flash('success', __('translation.revenues_edit_successfully'));
                return redirect()->route('school.students.revenues.index', ['type' => $request->type_id])->withErrors(__('translation.' . $e->getMessage()))->withInput();
                // if ($e->getCode() == 50)   session()->flash('error',  __('site.There_is_no_amount_available_in_the_safe'));
            }
            DB::rollback();
            dd($th);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentRevenue  $studentRevenue
     * @return \Illuminate\Http\Response
     */
    public function destroy($studentRevenue)
    {
        try {
            $renvue =  StudentRevenue::findOrFail($studentRevenue);
            DB::beginTransaction();
            SchoolTreasuryTransactionHistory::DestoryTransaction($renvue->transaction_id);
            $renvue->delete();
            DB::commit();
            session()->flash('success', __('translation.recept_revenues_success_fule_was_delete'));
            return redirect()->route('school.students.revenues.index', ['type' => $renvue->revenue_type]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            return redirect()->back()->withErrors(__('translation.6'));
            //throw $th;
        }

        // dd($student);
    }
}