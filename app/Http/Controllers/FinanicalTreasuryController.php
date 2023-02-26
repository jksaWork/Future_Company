<?php

namespace App\Http\Controllers;

use App\Models\FinancialTreasuryTransactionHistorys;
use App\Models\FinancialTreasury;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FinanicalTreasuryController extends Controller
{
    public function finanical()
    {
        $Treasury = FinancialTreasury::getInstance();
        // dd(FinancialTreasuryTransactionHistorys::getStatus());
        return view('admin.treasury.index', compact('Treasury'));
    }


    public function store(Request $request)
    {
        $data = $request->validate(['amount' => 'required']);
        try {
            FinancialTreasuryTransactionHistorys::MakeTransacaion($request->amount, 'main_treasury', $request->note);
            session()->flash('success', __('translation.pay_to_Treasury_was_done_success'));
            return redirect()->back();
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors(__('translation.6'));
        }
    }

    public function data()
    {
        $query = FinancialTreasuryTransactionHistorys::query()
            ->orderBy('id', 'desc');
        return  DataTables::of($query)
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->editColumn('transaction_type', function ($item) {
                return $item->getTransactionType();
            })
            ->editColumn('type', function ($item) {
                if ($item->type == 'credit') return  "<span class='badge badge-light-success'>" . __('translation.' . $item->type) . "</span>";
                else return "<span class='badge badge-light-danger'> " . __('translation.' . $item->type) . "</span>";
            })

            ->editColumn('amount', function ($item) {
                return number_format($item->amount, 2);
            })
            ->editColumn(
                'actions',
                'admin.treasury.data_table.actions'
            )
            ->rawColumns(['actions', 'transaction_type', 'type'])
            ->toJson();
    }
}
