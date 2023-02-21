<?php

namespace App\Http\Controllers;

use App\DataTables\OwnerDataTable;
use App\Http\Requests\OwnersRequest;
use App\Models\Owner;
use App\Repo\Interfaces\OwnerInterFace;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    public $interface;
    public function __construct(OwnerInterFace  $interface)
    {
        $this->interface = $interface;
        // dd($this->interface);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function data(){
        return $this->interface->getOwnerData();
     }
    public function index(OwnerDataTable $datatable)
    {

        return $this->interface->getOwnerIndex();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->interface->create();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OwnersRequest $request)
    {
        return $this->interface->StoreOwner($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function show(Owner $owner)
    {
        if(request()->has('status')) return $this->interface->ChangeStatus($owner);
        else return $this->interface->ShowOwnerData($owner);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function edit(Owner $owner)
    {
        return $this->interface->editOwner($owner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Owner $owner)
    {
        return $this->interface->UpdateOwner($request , $owner);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Owner $owner)
    {
        return $this->interface->deleteOwner($owner);
    }
    public function getOwners(Request $request){

        $search = $request->search;

        if($search == ''){
           $employees = Owner::where('status' , 1)->orderby('name','asc')->select('id','name')->limit(5)->get();
        }else{
           $employees = Owner::where('status' , 1)->orderby('name','asc')->select('id','name')->where('name', 'like', '%' .$search . '%')->limit(5)->get();
        }

        $response = array();
        foreach($employees as $employee){
           $response[] = array(
                "id"=>$employee->id,
                "text"=>$employee->name
           );
        }
        return response()->json($response);
     }
}