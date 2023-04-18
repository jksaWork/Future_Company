<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Supplier::get();
        return view('admin.supplier.index', compact('items'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =  $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        try {
            //  Insertt Supplier Into Data base
            Supplier::create($data);
            $request->session()->flash('success', __('translation.2'));
            return  redirect()->back();
        } catch (\Throwable $th) {
            dd($th);
            return  redirect()->back()->withErrors(__('translation.6'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */


    public function getAjaxData()
    {
        $query = Supplier::query(); #->whenHasRole(request()->role_id);

        return  DataTables::of($query)
            ->addColumn('record_select', 'admin.admins.data_table.record_select')
            ->editColumn('created_at', function ($user) {
                return $user->created_at->format('Y-m-d');
            })
            ->addColumn('actions', fn ($item) => view('admin.supplier.data_table.actions', compact('item')))

            ->rawColumns(['actions'])
            ->toJson();
    }

    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Supplier $supplier)
    {
        //
        $data =  $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);
        try {
            //  Update  Supplier Into Data base
            $supplier->update($data);
            $request->session()->flash('success', __('translation.2'));
            return  redirect()->back();
        } catch (\Throwable $th) {
            dd($th);
            return  redirect()->back()->withErrors(__('translation.6'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
}
