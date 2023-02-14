<?php

namespace App\Http\Controllers;

use App\Models\RealStateCategory;
use Exception;
use Illuminate\Http\Request;

class RealStateCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = RealStateCategory::WhenSerach()->get();
        return view('admin.real_state_category.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
        ]);
        try{
        $category = RealStateCategory::create($request->except('_token'));
        session()->flash('success' , __('translation.add_item_successfly'));
        return redirect()->route('realstate.categories.index');
        }
        catch(Exception $e){
        // dd($e);
        session()->flash('error' , __('transaltion.Some Thing Went Worng'));
        return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RealStateCategory  $realStateCategory
     * @return \Illuminate\Http\Response
     */
    public function show($realStateCategory)
    {
        $realStateCategory = RealStateCategory::findOrFail($realStateCategory);
        // dd($realStateCategory);
        try{
            $realStateCategory->ChangeStatus();
            // $realStateCategory->status = !$realStateCategory->status;
            // $realStateCategory->save();
            session()->flash('success', __('translation.Update  Was Done Succesfuly'));
            return redirect()->route('realstate.categories.index');
        }
            catch(Exception $e){
            // dd($e);
            session()->flash('error' , __('transaltion.Some Thing Went Worng'));

            return redirect()->back();

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RealStateCategory  $realStateCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(RealStateCategory $realStateCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RealStateCategory  $realStateCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RealStateCategory $realStateCategory)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
            $realStateCategory->update($request->except('_token' , 'method'));
            session()->flash('success', __('translation.Update  Was Done Succesfuly'));
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            session()->flash('error' , __('transaltion.Some Thing Went Worng'));

            return redirect()->back();

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RealStateCategory  $realStateCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(RealStateCategory $realStateCategory)
    {
        //
    }
}
