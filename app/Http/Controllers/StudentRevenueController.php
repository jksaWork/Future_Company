<?php

namespace App\Http\Controllers;

use App\Models\StudentRevenue;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StudentRevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('school.students.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function data()
    {
        $query = StudentRevenue::with('Category')
            ->typeScope()
            ->where('deleted_at', null);

        return  DataTables::of($query)
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->editColumn('revenue_type', function ($item) {
                return __('translation.' . $item->revenue_type);
            })
            ->editColumn('opration_type', function ($item) {
                return __('translation.' . $item->opration_type);
            })
            ->editColumn(
                'actions',
                'admin.realstate.data_table.actions'
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
        //
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