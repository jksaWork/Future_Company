<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\School_allowances;
use App\Models\school_types;
use App\Models\Category;
use App\Models\School_Teachers_allowances;

use App\Http\Requests\allowancesRequest;
use Illuminate\Http\Request;
use Exception;

class School_AllowancesController extends Controller
{

    public function index(Request $request)
    {

      
        $school_id =school_types::all();
        return view('admin.School_teachers.School_allowances.index' ,compact('school_id'));
    } //end of index


    public function create()
    {
        $school_id =school_types::all();
        return view('admin.School_teachers.School_allowances.create', compact('school_id'));
    } //end of create


    public function store(Request $request)
    {
        // return  $request;
        $request->validate([
            'allowances_name'=>'required|string|max:100',
            'allowances_value'=>'required',
            'school_id' =>'required',
        ]);

        try {
            $DATA = School_allowances::create([
                'allowances_name' => $request->allowances_name,
                'allowances_value' => $request->allowances_value,
                'school_id'=>$request->school_id,
                'status'=>$request->status,
            ]);
            //    return  $DATA;
            session()->flash('success', __('site.added_successfully'));
            return redirect()->route('School.allowances.index');
        } catch (Exception $e) {
            // dd($e);
            session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }
    } //end of store


    public function show()
    {
        //
    }


    public function edit( $id)
    {
        // return $id;
        $school_id = school_types::all();
        // return $Categorys;
        $allowancess = School_allowances::find($id);
        return view('admin.School_teachers.School_allowances.edit', compact('allowancess', 'school_id'));
    } //end of edit

    public function update(allowancesRequest $request, $id)
    {
        // return $request;
        try{


        //    return $id;
        $allowances = School_allowances::findOrFail($id);

        $allowances->update([
            'allowances_name' => $request->allowances_name,
            'allowances_value' => $request->allowances_value,
            'school_id'=>$request->school_id,
        ]);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('School.allowances.index');
        }catch(Exception $e){
            // dd($e);
            session()->flash('error',  __('site.Some_Thing_Went_Worng'));
            return redirect()->back();
        }

    } //end of update

    public function destroy($id)
    {

        try{
        $s  = School_Teachers_allowances::where([
            ['allowances_id', $id],
        ])->get();
       $d= $s->count();
       if ($d == 0) {
        $allowances = School_allowances::findOrFail($id);
        $allowances->delete();
        session()->flash('error', __('site.has_been_transferred_successfully'));
        return redirect()->route('School.allowances.index');
   
 
       } else {
        session()->flash('error', __('site.You_cannot_delete_this_field'));
        return redirect()->route('School.allowances.index');
       }
    }catch(Exception $e){
        dd($e);
        session()->flash('error' ,  __('site.Some_Thing_Went_Worng'));
        return redirect()->back();
    }
      
    } //end of destroy

}//end of controller
