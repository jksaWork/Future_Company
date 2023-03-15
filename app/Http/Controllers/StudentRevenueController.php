<?php

namespace App\Http\Controllers;

use App\Models\Owner;
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
        $schooles = Owner::limit(5)->get();
        return view('school.students.create', compact('headings', 'schooles'));
    }

    public function data()
    {
        $query = StudentRevenue::query() #  TODO: With('Category')
            ->typeScope();
        // ->where('deleted_at', null);
        // dd('jksa');
        return  DataTables::of($query)
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->editColumn('revenue_type', function ($item) {
                return __('translation.' . $item->revenue_type);
            })
            ->editColumn('school_id', function ($item) {
                return $item->School->name;
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
                'recept_date' => $request->recept_date ?? date('y-m-d')
            ];
            $renvue = StudentRevenue::create($data);

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
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StudentRevenue  $studentRevenue
     * @return \Illuminate\Http\Response
     */
    public function show(StudentRevenue $studentRevenue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StudentRevenue  $studentRevenue
     * @return \Illuminate\Http\Response
     */
    public function edit(StudentRevenue $studentRevenue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StudentRevenue  $studentRevenue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StudentRevenue $studentRevenue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudentRevenue  $studentRevenue
     * @return \Illuminate\Http\Response
     */
    public function destroy(StudentRevenue $studentRevenue)
    {
        //
    }
}