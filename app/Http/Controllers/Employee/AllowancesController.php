<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\allowances;
use App\Models\Category;
use App\Models\employee_allowances;

use App\Http\Requests\allowancesRequest;
use Illuminate\Http\Request;
use Exception;

class AllowancesController extends Controller
{

    public function index(Request $request)
    {

        $allowancess = allowances::all();

        return view('admin.Employee.allowances.index', compact('allowancess'));
    } //end of index


    public function create()
    {
        $Category = Category::all();
        return view('admin.Employee.allowances.create', compact('Category'));
    } //end of create


    public function store(allowancesRequest $request)
    {
        // return  $request;

        try {
            $DATA = allowances::create([
                'allowances_name' => $request->allowances_name,
                'allowances_value' => $request->allowances_value,
                'status'=>$request->status,
            ]);
            //    return  $DATA;
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('Employee.allowances.index');
        } catch (Exception $e) {
            // dd($e);
            session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }
    } //end of store


    public function show(allowances $allowances)
    {
        //
    }


    public function edit(allowances $allowances, $id)
    {
        $Categorys = Category::all();
        // return $Categorys;
        $allowancess = allowances::find($id);
        return view('admin.Employee.allowances.edit', compact('Categorys', 'allowancess'));
    } //end of edit

    public function update(allowancesRequest $request, allowances $allowances)
    {
        // return $request;
        try{


        //    return $id;
        $allowances = allowances::findOrFail($request->pro_id);

        $allowances->update([
            'allowances_name' => $request->allowances_name,
            'allowances_value' => $request->allowances_value,
        ]);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('Employee.allowances.index');
        }catch(Exception $e){
            // dd($e);
            session()->flash('error',  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }

    } //end of update

    public function destroy( allowances $allowances , $id)
    {

        try{
        $s  = employee_allowances::where([
            ['allowances_id', $id],
        ])->get();
       $d= $s->count();
       if ($d == 0) {
        $allowances = allowances::findOrFail($id);
        $allowances->delete();
        session()->flash('error', __('site.has_been_transferred_successfully'));
        return redirect()->route('Employee.allowances.index');
   
 
       } else {
        session()->flash('error', __('site.You_cannot_delete_this_field'));
        return redirect()->route('Employee.allowances.index');
       }
    }catch(Exception $e){
        // dd($e);
        session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }
      
    } //end of destroy

}//end of controller
