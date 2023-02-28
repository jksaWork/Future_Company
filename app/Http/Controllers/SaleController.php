<?php

namespace App\Http\Controllers;

use App\Models\FinancialTreasuryTransactionHistorys;
use App\Models\RealState;
use App\Models\RealstateInstallment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use DB;

class SaleController extends Controller
{
    public function receptInstallment(Request $request)
    {
        // return ($request);
        $request->validate([
            'realstate_id' => 'required',
            'installment_id' => 'required',
        ]);
        try {
            DB::beginTransaction();
            $realstate = RealState::with('CurrentOwner')->findOrFail($request->realstate_id);
            // Check It Is Has Oowner OR Not;
            if (!$realstate->is_sale) {
                return redirect()->back()->withErrors(__('translation.this_real_State_not_have_owner'));
            }

<<<<<<< HEAD
        $owner_id = $Installment->RealState->CurrentOwner[0]->id;
        $owner_name = $Installment->RealState->CurrentOwner[0]->name;
        $res = FinancialTreasuryTransactionHistorys::MakeTransacaion($Installment->amount, 'installment', $owner_name . '-' . __('translation.installment_order_' . $Installment->order_number, $id));
        $id =  DB::table('installments_history')
            ->insertGetId([
                'realstate_id' => $Installment->realstate_id,
                'owner_id' => $owner_id,
                'amount' => $Installment->amount,
                'order_number' => $Installment->order_number,
                // 'transavtio_'
            ]);


        session()->flash('success', __('translation.installment_sucess'));
        return redirect()->route('realstate.realstate.show', $Installment->realstate_id);
=======

            $Installment = RealstateInstallment::findOrFail($request->installment_id);
            $Installment->is_payed = true;
            $Installment->save();

            $owner_id = $realstate->CurrentOwner[0]->id;
            $owner_name = $realstate->CurrentOwner[0]->name;
            // dd($owner_id, $owner_name);
            $id =  DB::table('installments_history')
                ->insertGetId([
                    'realstate_id' => $Installment->realstate_id,
                    'owner_id' => $owner_id,
                    'amount' => $Installment->amount,
                    'order_number' => $Installment->order_number,
                ]);
            // dd('here is cood');
            //  Make Transaction To Save Install Ment
            $note = $owner_name . '-' . __('translation.installment_order_' . $Installment->order_number);
            $transaction = FinancialTreasuryTransactionHistorys::MakeTransacaion($Installment->amount, 'installment', $note, $id);
            // Update Refernce Id
            DB::table('installments_history')
                ->where('id', $id)
                ->update(['transaction_id' => $transaction->id]);

            session()->flash('success', __('translation.installment_sucess'));
            DB::commit();
            return redirect()->route('realstate.realstate.show', $Installment->realstate_id);
        } catch (\Throwable $th) {
            DB::rollback();
            return $th;
            return redirect()->back()->withErrors(__('translation.6'));
        }
>>>>>>> 19d0d92d355a7874040741a2d444549ca57aa8b0
    }

    public function getRealStateInstallments()
    {
        $realstate = RealstateInstallment::where('realstate_id', request()->id)->get();
        return response()->json($realstate, 200);
    }

    public function receptRealStateInstallment()
    {
        return view('admin.realstate.sale.installments');
    }

    public function assignSaleOwner()
    {
        return view('admin.realstate.sale.asign');
    }

    public function saleHistory()
    {
        return view('admin.realstate.sale.sale_history');
    }

    public function saleHistoryData()
    {
        $query = RealState::with('CurrentOwner')->where('type', 'sale')->where('is_rent', 1);
        return  DataTables::of($query)
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->editColumn('sale_status', function ($item) {
                if ($item->CurrentOwner[0]->pivot->sale_status)
                    return  "<span class='badge badge-light-success'>" . __('translation.sale_status_installment_is_done') . "</span>";
                else
                    return "<span class='badge badge-light-info'> " . __('translation.sale_status_under_iinstallment') . "</span>";
            })
            ->editColumn('owner_name', function ($item) {
                return  $item->CurrentOwner[0]->name;
            })

            ->editColumn('owner_phone', function ($item) {
                return  $item->CurrentOwner[0]->phone;
            })
            ->editColumn('is_sale', fn ($item) => $item->getSaleStatusWithSpan('is_sale', 'saled'))
            ->editColumn('category_id', fn ($item) => $item->Category->name ?? '')
            ->editColumn(
                'actions',
                'admin.realstate.sale.data_table.action'
            )
            ->rawColumns(['actions', 'sale_status',  'status', 'is_rent', 'is_sale', 'owner_phone', 'owner_name'])
            ->toJson();
    }
    public function InstallmentsHistory()
    {
        return view('admin.realstate.sale.installment_history');
    }
    public function InstallmentsHistoryData()
    {
        $query = DB::table('installments_history')->select(
            [
                'installments_history.*',
                'installments_history.amount',
                'installments_history.order_number',
                'installments_history.realstate_id',
                'installments_history.owner_id',
                't1.name',
                't1.phone',
                't2.title',
                't2.address',
                't2.realstate_number',
            ]

        )
            ->when(request()->id != null, function ($q) {
                $q->where('installments_history.id', request()->id);
            })
            ->when(request()->realstate_id != null, function ($q) {
                $q->where('installments_history.realstate_id', request()->realstate_id);
            })
            ->when(request()->owner_id != null, function ($q) {
                $q->where('installments_history.owner_id', request()->owner_id);
            })
            ->join('owners as t1', 'installments_history.owner_id', 't1.id')
            ->leftJoin('real_states as t2', 'installments_history.realstate_id', 't2.id');

        return DataTables::of($query)
            ->editColumn('order_number', fn ($item) =>   "<span class='badge badge-light-info'> " . __('translation.installment_order_' . $item->order_number) . "</span>")
            ->editColumn(
                'actions',
                'admin.realstate.rent.reveune.actions'
            )
            ->rawColumns(['actions', 'order_number',  'status', 'is_rent', 'is_sale', 'owner_phone', 'owner_name'])
            ->toJson();
    }
}
