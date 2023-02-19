<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RealState;
use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;

class RentController extends Controller
{
    public function FinshRent(Request $request){
        $request->validate(['real_state_id' => 'required']);
        try {
            $realstate = RealState::find($request->real_state_id);
            $realstate->is_rent = 0;
            $realstate->save();
            DB::select('update owners_realstates set rent_status = 0    where realstate_id = ? ', [$request->real_state_id]);
            session()->flash('success' ,  __('translation.rent_is_finsh_sucess'));
        return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(__('translation.6'));
        }
    }

    public function AssignOwnerTORealState($id = null){
        $realstate =  $id ? RealState::find($id): null;
        return  view('admin.realstate.assing' ,compact('realstate'));
    }
    public function Asgin(Request $request){
        // return $request;
        $request->validate([
            'realstate_id' => 'required',
            'owner_id'=> 'required',
        ]);
        try {
            $realstate = RealState::findOrFail($request->realstate_id);
            if($realstate->status == 0 ||$realstate->is_rent == true){
                return  redirect()->back()->withErrors(__('translation.this_realstate_under_rent'));
            }
            $realstate->is_rent = true;
            $realstate->save();

            DB::table('owners_realstates')->insert(
                ['owner_id' => $request->owner_id, 'realstate_id' => $request->realstate_id]
            );
            session()->flash('success' , __('translation.assgin_new_owner_was_done'));
            return redirect()->route('realstate.realstate.show' , $realstate->id);
        } catch (\Throwable $th) {
            return  redirect()->back()->withErrors(__('translation.6'));

        }
    }

    public function renthistory(Request $request){
        return view('admin.realstate.rent.index');
    }

    public function renthistoryData(){
        $query = RealState::with('CurrentOwner')->where('type' , 'rent')->where('is_rent' , 1);
        return  DataTables::of($query)
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->editColumn('status', function ($item) {
                if ($item->CurrentOwner[0]->pivot->rent_status)
                    return  "<span class='badge badge-light-success'>" . __('translation.underrent') ."</span>";
                else
                      return "<span class='badge badge-light-danger'> " . __('translation.finshed') ."</span>";

            })
            ->editColumn('owner_name', function ($item) {
                return  $item->CurrentOwner[0]->name;
            })

            ->editColumn('owner_phone', function ($item) {
                return  $item->CurrentOwner[0]->phone;
            })

            ->editColumn('month_count', function ($item) {
                return  $item->CurrentOwner[0]->pivot->month_count;
            })
            ->editColumn('is_rent', fn ($item) => $item->getSaleStatusWithSpan('is_rent', 'rented'))
            ->editColumn('category_id', fn ($item) => $item->Category->name ?? '')
            ->editColumn(
                'actions',
                'admin.realstate.rent.data_table.actions'
            )
            ->rawColumns(['actions', 'status', 'is_rent', 'is_sale' , 'owner_phone'  ,'owner_name'])
            ->toJson();

    }
}
