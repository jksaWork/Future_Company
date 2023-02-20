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

        $categories = RealStateCategory::where('type' ,request()->type ?? 'rent'  )->get();
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
        // dd('hello');
        $request->validate([
            'title' => 'required',
            'price' => 'required|numeric',
            'description' => 'required',
            'realstate_number' => 'required',
            'address' => 'required',
            'category_idd' => 'required',
            'type' => 'required',
            'installment' => 'required_if:type,sale',
            'installment.*.precentage' => 'required',
            'installment.*.amount' => 'required',
            'installment.*.date' => 'required',
        ]);
    //    return $request;

        try {

            $data = array_merge(
                $request->except('_token', 'category_idd', 'attachments', 'installment'),
                [
                    'category_id' => $request->category_idd,
                    'type' => $request->type
                 ]
            );
            // dd($data);
            $realstate  = RealState::create($data);
            Attachments::AttachMUltiFIleFiles($request->attachments, $realstate, 'realstate/attachments');
            //  Check If The Request Comming By Sale Type
            if($request->has('type') && $request->type == 'sale') $this->SaveTheIstallment($realstate, $request->installment);
            return redirect()->route('realstate.realstate.index', ['type' => $request->type]);
        } catch (\Throwable $th) {
            dd($th);
        }
    }


/**
     * To Save The Installments On Database
     *
     * @param  \App\Models\RealState  $realState
     * @param  \App\Models\RealState  $realState
     * @return void
     */
    public function SaveTheIstallment( RealState $realstate , $installment)
    {
        $collect = collect($installment);
        // Retrive Data And Handel Status
        $data = $collect->map(function($el) use ($realstate)  {
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

        try {
            $rel = RealState::findOrFail($realStat_id);
            if (request()->has('status')) return $this->handelStatus($rel);
            else return $this->HandelShow($rel);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(__('translation.Some Thing Went Worng'));
        }
    }



    public function handelStatus(RealState $realState)
    {
        $realState->ChangeStatus();
        return redirect()->route('realstate.realstate.index');
    }


    public function handelShow(RealState $realState)
    {
        try {
            return view('admin.realstate.show' , compact('realState')) ;
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
            session()->flash('success', __('translation.Update Was Done Succesfuly'));
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
            return  redirect()->route('realstate.realstate.index');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function getGetRealState(Request $request){

        $search = $request->search;

        if($search == ''){
           $employees = RealState::
           where([
            'status' => 1,
            'is_rent' => 0,
            'is_sale' => 0
           ])->
           orderby('title','asc')->select('id','title')->limit(5)->get();
        }else{
           $employees = RealState::where([
            'status' => 1,
            'is_rent' => 0,
            'is_sale' => 0
           ])-> orderby('title','asc')->select('id','title')->where('name', 'like', '%' .$search . '%')->limit(5)->get();
        }

        $response = array();
        foreach($employees as $employee){
           $response[] = array(
                "id"=>$employee->id,
                "text"=>$employee->title
           );
        }
        return response()->json($response);
     }

}