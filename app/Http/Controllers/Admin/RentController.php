<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialTreasuryTransactionHistorys;
use App\Models\RealState;
use Illuminate\Http\Request;
use DB;
use Exception;
use Illuminate\Auth\Events\Validated;
use Yajra\DataTables\Facades\DataTables;

class RentController extends Controller
{
    public function FinshRent(Request $request)
    {
        $request->validate(['real_state_id' => 'required']);
        try {
            $realstate = RealState::find($request->real_state_id);
            $realstate->is_rent = 0;
            $realstate->save();
            DB::select('update owners_realstates set rent_status = 0    where realstate_id = ? ', [$request->real_state_id]);
            session()->flash('success',  __('translation.rent_is_finsh_sucess'));
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(__('translation.6'));
        }
    }

    public function AssignOwnerTORealState($id = null)
    {
        $realstate =  $id ? RealState::find($id) : null;
        return  view('admin.realstate.assing', compact('realstate'));
    }
    public function Asgin(Request $request)
    {
        // return $request;
        $request->validate([
            'realstate_id' => 'required',
            'owner_id' => 'required',
            'type' => 'required|in:rent,sale',
        ]);
        try {
            $realstate = RealState::findOrFail($request->realstate_id);
            if ($realstate->status == 0 || $realstate->{'is_' . $request->type} == true) {
                return  redirect()->back()->withErrors(__('translation.this_realstate_under_opration_or_not_ready'));
            }
            $realstate->{'is_' . $request->type} = true;
            $realstate->save();

            DB::table('owners_realstates')->insert(
                [
                    'owner_id' => $request->owner_id,
                    'realstate_id' => $request->realstate_id,
                    'type' => $request->type,
                ]
            );
            session()->flash('success', __('translation.assgin_new_owner_was_done'));
            return redirect()->route('realstate.realstate.show', $realstate->id);
        } catch (\Throwable $th) {
            return  redirect()->back()->withErrors(__('translation.6'));
        }
    }

    public function renthistory()
    {

        return view('admin.realstate.rent.index');
    }

    public function renthistoryData()
    {
        $query = RealState::with('CurrentOwner')->where('type', 'rent')->where('is_rent', 1);
        return  DataTables::of($query)
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->editColumn('status', function ($item) {
                if ($item->CurrentOwner[0]->pivot->rent_status)
                    return  "<span class='badge badge-light-success'>" . __('translation.underrent') . "</span>";
                else
                    return "<span class='badge badge-light-danger'> " . __('translation.finshed') . "</span>";
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
            ->rawColumns(['actions', 'status', 'is_rent', 'is_sale', 'owner_phone', 'owner_name'])
            ->toJson();
    }
    //  Receipt Revenue  Section
    public function receiptRevenue($id = null)
    {
        $realstate =  $id ? RealState::find($id) : null;
        return view('admin.realstate.rent.receiptrevenue', compact('realstate'));
    }

    public function receiptRevenueSetp2(Request $request)
    {
        $realstate = RealState::with('CurrentOwner')->find($request->realstate_id);
        $month_number = $request->month_number;
        if (count($realstate->CurrentOwner) == 0) throw new Exception(__('translation.has_no_current_user'));
        return view('admin.realstate.rent.setp_2', compact('realstate', 'month_number'));
    }
    public function handelRevenue(Request $request)
    {
        $request->validate([
            'realstate_id' => 'required',
            'month_number' => 'required',
        ]);
        //  Fecth Payment Is Exist Or Not
        //try {
        $is_payed = DB::select('select count(id) as c from rent_revenues where realstate_id = ? and month_number = ?', [$request->realstate_id,  $request->month_number]);
        //  If Is Exist the Spesfic Month And And RealState ID
        if ($is_payed[0]->c != 0)
            return redirect()->back()->withErrors(__('translation.the_select_month_was_payed'));
        // Check If Request Has No OWner ID return It To Go To Setp Tow
        if (!request()->has('owner_id')) return $this->receiptRevenueSetp2($request);
        // IF esle INsert The Renveu To DataBase
        $realstate = RealState::findOrFail($request->realstate_id);
        // insert The New Row
        $id = DB::table('rent_revenues')->insertGetId(
            [
                'owner_id' => $request->owner_id,
                'month_number' => $request->month_number,
                'realstate_id' => $request->realstate_id,
                'price' => $realstate->price,
                'status' => 1,
            ]
        );
        // Add Money To History
        $transaction = FinancialTreasuryTransactionHistorys::MakeTransacaion($realstate->price, 'revenues', $realstate->title . '-' . $realstate->address, $id);
        DB::table('rent_revenues')
            ->where('id', $id)
            ->update(['transaction_id' => $transaction->id]);
        return redirect()->route('realstate.realstate.show', $request->realstate_id);
        // } catch (\Throwable $th) {
        //     return redirect()->back()->withErrors($th->getMessage());
        // }
    }

    public function revenueHsitory()
    {
        return view('admin.realstate.rent.revenues');
    }

    public function revenueHsitoryData()
    {
        // if(request()->has('status')) dd('Hello');
        $query = DB::table('rent_revenues')->select(
            [
                'rent_revenues.*',
                'rent_revenues.status',
                'rent_revenues.price',
                'rent_revenues.month_number',
                'rent_revenues.realstate_id',
                'rent_revenues.owner_id',
                't1.name',
                't1.phone',
                't2.title',
                't2.address',
                't2.realstate_number',
            ]
        )
            ->when(request()->status != null, function ($q) {
                $q->where('rent_revenues.status', request()->status);
            })
            ->when(request()->realstate_id != null, function ($q) {
                $q->where('rent_revenues.realstate_id', request()->realstate_id);
            })
            ->when(request()->owner_id != null, function ($q) {
                $q->where('rent_revenues.owner_id', request()->owner_id);
            })
            ->join('owners as t1', 'rent_revenues.owner_id', 't1.id')
            ->leftJoin('real_states as t2', 'rent_revenues.realstate_id', 't2.id');

        return DataTables::of($query)
            ->editColumn('status', function ($item) {
                if ($item->status) return  "<span class='badge badge-light-success'>" . __('translation.revened') . "</span>";
                else return "<span class='badge badge-light-danger'> " . __('translation.unrevened') . "</span>";
            })
            ->editColumn(
                'actions',
                'admin.realstate.rent.reveune.actions'
            )
            ->rawColumns(['actions', 'status', 'is_rent', 'is_sale', 'owner_phone', 'owner_name'])
            ->toJson();
    }
}