<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FinancialTreasury;
use App\Models\spendings;
use App\Models\Advances;
use App\Models\employee_allowances;
use App\Models\salaries;
use App\Models\employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $data['charttwo'] = DB::select('SELECT Count(id) as `Data` ,status as label FROM `offers`   GROUP by status');
        $data['chartOne'] = DB::select('SELECT DAYNAME(created_at) as label , Count(id) as Data FROM offers  GROUP BY DAYNAME(created_at)');
        $sum = collect([33, 22, 27]);
        $data['recored'] = $sum->map(fn ($el) => floor($el / $sum->sum() * 100));

        $employe =  employee::count();
        // return $employe;
        $spendings = spendings::select(
            DB::raw('SUM(spending_value) as sum')
        )->get();
        $FinancialTreasury = FinancialTreasury::select(
            DB::raw('SUM(total) as sum')
        )->get();
        $employee_allowances = employee_allowances::where('status' , 1)->get();

        $S=0;
        foreach ($employee_allowances as $key => $employee_allowance) {
            
            $S += $employee_allowances[0]->Allowances_id->allowances_value;
        }

        $Advances = Advances::select(
            DB::raw('SUM(Advances_value) as sum')
        )->get();
        $salaries = salaries::select(
            DB::raw('SUM(totle_salaries) as sum')
        )->get();
                     
        
        $spendings_data = spendings::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(spending_value) as sum')
        )->groupBy('month')->get();
// dd($spendings_data[2]->month);

        // return $S;
        return view('admin.dashboard.index', $data, compact('employe', 'spendings', 'FinancialTreasury','S','Advances','salaries','spendings_data'));
    }
    public function getIndex()
    {
        return redirect()->route('admin.login');
    }
}
