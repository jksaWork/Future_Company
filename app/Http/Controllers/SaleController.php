<?php

namespace App\Http\Controllers;

use App\Models\RealState;
use App\Models\RealstateInstallment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{
    public function receptInstallment(Request $request){
        $Installment = RealstateInstallment::findOrFail($request->installment_id);
        $Installment->is_payed = true;
        $Installment->save();
         return redirect()->route('realstate.realstate.show', $Installment->realstate_id);
    }



    public function assignSaleOwner(){
        return view('admin.realstate.sale.asign');
    }

    public function saleHistory(){
        return view('admin.realstate.sale.sale_history');
    }

    public function saleHistoryData(){
        $query = RealState::with('CurrentOwner')->where('type' , 'sale')->where('is_rent' , 1);
        return  DataTables::of($query)
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->editColumn('sale_status', function ($item) {
                if ($item->CurrentOwner[0]->pivot->sale_status)
                    return  "<span class='badge badge-light-success'>" . __('translation.sale_status_installment_is_done') ."</span>";
                else
                      return "<span class='badge badge-light-info'> " . __('translation.sale_status_under_iinstallment') ."</span>";
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
            ->rawColumns(['actions', 'sale_status',  'status', 'is_rent', 'is_sale' , 'owner_phone'  ,'owner_name'])
            ->toJson();
    }
}
