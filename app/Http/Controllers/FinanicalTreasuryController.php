<?php

namespace App\Http\Controllers;

use App\Models\FinancialTreasuryTransactionHistorys;
use App\Models\FinancialTreasury;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use DB;
use DivisionByZeroError;
use Exception;

class FinanicalTreasuryController extends Controller
{
    // jksa_jksaa
    public function finanical()
    {
        $Treasury = FinancialTreasury::getInstance();
        // dd(FinancialTreasuryTransactionHistorys::getStatus());
        return view('admin.treasury.index', compact('Treasury'));
    }


    public function store(Request $request)
    {
        $data = $request->validate(['amount' => 'required|numeric|min:0']);
        try {
            DB::beginTransaction();
            FinancialTreasuryTransactionHistorys::MakeTransacaion($request->amount, 'main_treasury', $request->note);
            session()->flash('success', __('translation.pay_to_Treasury_was_done_success'));
            DB::commit();
            return redirect()->back();
        } catch (\Throwable $th) {
            if ($th->getCode() == 51) {
                DB::commit();
                session()->flash('success', __('translation.pay_to_Treasury_was_done_success'));
                return redirect()->back()->withErrors(__('translation.' . $th->getMessage()));
            }
            DB::rollback();
            return redirect()->back()->withErrors(__('translation.6'));
        }
    }



    public function update(Request $request, $id)
    {
        // return $id;
        $data = $request->validate([
            'amount' => 'required',
        ]);
        try {
            DB::beginTransaction();
            FinancialTreasuryTransactionHistorys::EditTransaction($id, $request->amount);
            session()->flash('success', __('translation.Edit_pay_to_Treasury_was_done_success'));
            DB::commit();

            return redirect()->back();
        } catch (\Throwable $th) {
            if ($th->getCode() == 51) {

                DB::commit();
                session()->flash('success', __('translation.pay_to_Treasury_was_done_success'));
                return redirect()->back()->withErrors(__('translation.' . $th->getMessage()));
            }
            DB::rollback();
            return redirect()->back()->withErrors(__('translation.6'));
        }
    }

    public function data()
    {
        $query = FinancialTreasuryTransactionHistorys::whenType()
            ->whenTransactionType()
            ->WhenFromDate()
            ->when(request()->id != null, fn ($q) => $q->where('id', request()->id))
            ->orderBy('id', 'desc');
        // dd($query->get());
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
                fn ($i) => view(
                    'admin.treasury.data_table.actions',
                    ['item' => $i]
                )
            )
            ->rawColumns(['actions', 'transaction_type', 'type'])
            ->toJson();
    }
    public function revenues()
    {
        $data = [];
        $Treasury =  DB::table(
            'financial_treasuries'
        )->select(
            DB::raw('(select sum(amount) from financial_treasury_transaction_historys where type = "credit" and  transaction_type ="revenues") as revenues_total '),
            DB::raw('(select sum(amount) from financial_treasury_transaction_historys where type = "credit" and transaction_type ="installment") as installment_total '),
            DB::raw('(select sum(amount) from financial_treasury_transaction_historys where type = "credit" and transaction_type ="main_treasury") as main_treasury'),
            DB::raw('(select sum(amount) from financial_treasury_transaction_historys where type = "credit" ) as total '),
        )->get();
        $Treasury = $Treasury[0];
        foreach (['revenues_total', 'main_treasury', 'installment_total'] as  $value) {
            $data[$value] = $this->getPrecetage($Treasury, $value);
        }
        return view('admin.treasury.revenues', $data);
    }

    public function spending()
    {
        $data = [];
        $Treasury =  DB::table(
            'financial_treasuries'
        )->select(
            DB::raw('(select sum(amount) from financial_treasury_transaction_historys where type = "debit"  and  transaction_type in ("incentives" , "salries" , "advance" ) ) as employee_section'),
            DB::raw('(select sum(amount) from financial_treasury_transaction_historys where type = "debit" and transaction_type ="spending") as spending_section'),
            DB::raw('(select sum(amount) from financial_treasury_transaction_historys where type = "debit" ) as total '),
        )->get();
        $Treasury = $Treasury[0];
        foreach (['employee_section', 'spending_section'] as  $value) {
            $data[$value] = $this->getPrecetage($Treasury, $value);
        }
        // dd($data);
        return view('admin.treasury.spending', $data);
    }

    public function getPrecetage($object, $key)
    {
        try {
            $value = $object->$key;
            $total = $object->total;
            return floor(($value / $total) * 100);
        } catch (DivisionByZeroError $en) {
            return __('translation.non_predictive');
        }
    }
}
