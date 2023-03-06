<?php

namespace App\Http\Controllers;

use App\Models\Attachments;
use App\Models\Category;
use App\Models\RealState;
use App\Models\RealStateCategory;
use App\Models\RealstateInstallment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RealStateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.realstate.index');
    }


    public function data()
    {
        $query = RealState::with('Category')
            ->typeScope()
            ->StatusScope()
            ->rentOrSaleScope();

        return  DataTables::of($query)
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->editColumn('status', function ($item) {
                return  $item->getStatusWithSpan();
            })
            ->editColumn('type', function ($item) {
                return __('translation.' . $item->type);
            })
            ->editColumn('is_sale', fn ($item) => $item->getSaleStatusWithSpan('is_sale', 'saled'))
            ->editColumn('is_rent', fn ($item) => $item->getSaleStatusWithSpan('is_rent', 'rented'))
            ->editColumn('category_id', fn ($item) => $item->Category->name ?? '')
            ->editColumn(
                'actions',
                'admin.realstate.data_table.actions'
            )
            ->rawColumns(['actions', 'status', 'is_rent', 'is_sale'])
            ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = RealStateCategory::where('type', request()->type ?? 'rent')->get();
        return view('admin.realstate.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'realstate_number' => 'required',
            'address' => 'required',
            'category_idd' => 'required',
            'type' => 'required',
            'status' => 'required',
            'installment' => 'required_if:type,sale',
            'installment.*.precentage' => 'required',
            'installment.*.amount' => 'required',
            'installment.*.date' => 'required',
        ]);
        //    return $request;

        try {
            // return $request;
            $data = array_merge(
                $request->except('_token', 'category_idd', 'attachments', 'installment'),
                [
                    'category_id' => $request->category_idd,
                    'type' => $request->type,
                    'status' => $request->status == 'ready',
                ]
            );
            // dd($data);

            $realstate  = RealState::create($data);
            Attachments::AttachMUltiFIleFiles($request->attachments, $realstate, 'realstate/attachments');
            //  Check If The Request Comming By Sale Type
            if ($request->has('type') && $request->type == 'sale') $this->SaveTheIstallment($realstate, $request->installment);
            return redirect()->route('realstate.realstate.index', ['type' => $request->type]);
        } catch (\Throwable $th) {
            // dd($th);
            return redirect()->back()->withErrors(__('translation.6'));
        }
    }


    /**
     * To Save The Installments On Database
     *
     * @param  \App\Models\RealState  $realState
     * @param  \App\Models\RealState  $realState
     * @return void
     */
    public function SaveTheIstallment(RealState $realstate, $installment)
    {
        $collect = collect($installment);
        // Retrive Data And Handel Status
        $data = $collect->map(function ($el, $index) use ($realstate) {
            $el['order_number'] = $index + 1;
            $el['realstate_id'] = $realstate->id;
            $el['is_payed'] = $el['is_payed'][0]  ?? 0;
            return $el;
        });

        RealstateInstallment::insert($data->all());
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RealState  $realState
     * @return \Illuminate\Http\Response
     */
    public function show($realStat_id)
    {
// return $realStat_id;
        try {
            $rel = RealState::with('attachments', 'Category', 'Owners', 'CurrentOwner', 'Installments.Owner')->findOrFail($realStat_id);
            if (request()->has('status')) return $this->handelStatus($rel);
            else return $this->HandelShow($rel);
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->withErrors(__('translation.Some Thing Went Worng'));
        }
    }



    public function handelStatus(RealState $realState)
    {
        $realState->ChangeStatus();
        return redirect()->route('realstate.realstate.index', ['type' => $realState->type]);
    }


    public function handelShow(RealState $realState)
    {
        try {
            // $realState->load('')
            return view('admin.realstate.show', compact('realState'));
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RealState  $realState
     * @return \Illuminate\Http\Response
     */
    public function edit($realState_id)
    {
        $realState = RealState::findOrFail($realState_id);
        $categories = Category::get();
        return view('admin.realstate.edit', compact('realState', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RealState  $realState
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $realState)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'realstate_number' => 'required',
            'address' => 'required',
        ]);
        try {
            $realState = RealState::find($realState);
            $realState->update($data);
            session()->flash('success', __('translation.4'));
            return redirect()->route('realstate.realstate.index', ['type' => $realState->type]);
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RealState  $realState
     * @return \Illuminate\Http\Response
     */
    public function destroy($realState)
    {
        try {
            RealState::findOrFail($realState)->delete();
            session()->flash('success', __('translation.5'));
            return  redirect()->route('realstate.realstate.index', ['type' => $realState->type]);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function getGetRealState(Request $request)
    {

        $search = $request->search;
        $type = $request->type;
        $is_rent = $request->is_rent;
        $is_sale = $request->is_sale;

        $employees = RealState::where('status',  1)
            ->when($search, function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%')
                    ->orWhere('realstate_number', 'like', '%' . $search . '%');
            })
            ->when($is_sale, function ($q) {
                $q->where('is_sale', 0);
            })->when($is_rent, function ($q) {
                $q->where('is_rent', 0);
            })
            ->when($type, function ($q) {
                $q->where('type', request()->type);
            })
            ->orderby('title', 'asc')->select('id', 'title')
            ->limit(5)->get();
        //  Return Reponose
        $response = array();
        foreach ($employees as $employee) {
            $response[] = array(
                "id" => $employee->id,
                "text" => $employee->title
            );
        }
        return response()->json($response);
    }
}
