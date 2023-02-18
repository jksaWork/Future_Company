<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RealState;
use Illuminate\Http\Request;
use DB;
class RentController extends Controller
{
    public function FinshRent(Request $request){

        try {
            DB::select('update owners_realstates set rent_status = 0    where realstate_id = ? ', [$request->real_state_id]);
            session()->flash('success' ,  __('translation.3'));
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
            DB::table('owners_realstates')->insert(
                ['owner_id' => $request->owner_id, 'realstate_id' => $request->realstate_id]
            );
            session()->flash('success' , __('translation.assgin_new_owner_was_done'));
            return redirect()->route('realstate.realstate.show' , $realstate->id);
        } catch (\Throwable $th) {
            return  redirect()->back()->withErrors(__('translation.6'));

        }
    }
}
