<?php

namespace App\Repo\Repositories;

use App\Models\Attachments;
use App\Models\Client;
use App\Models\Owner;
use App\Repo\Interfaces\ClientInteface;
use App\Repo\Interfaces\OwnerInterFace;
use Exception;

class  OwnerRepository implements OwnerInterFace {
    public function create()
    {
        return view('admin.owners.create');
    }
    public function StoreOwner($request){
        $this->StoreOwnerInDatabse($request);
        return redirect()->route('owners.index');
    }

    public function StoreOwnerInDatabse($request){
        try{
            // return

            $data = $request->all();
            $data['password'] = bcrypt($request->password);
            $filterd = collect($data)->except('_token', 'owner_attachment');
             $Owner  = Owner::create($filterd->toArray());
            if($request->hasFile('owner_attachment')){
                $filename = $request->owner_attachment->store('owner_attachment');
                // $Owner->attachments()->create([])
                $attachment  = new Attachments();
                // $attachment->attacheable = $agent->id;
                $attachment->url = $filename;
                $Owner->attachments()->save($attachment);
            }
            return $Owner->load('attachments');
        }catch(Exception $e){
            dd($e);
            // return $e;
        }
    }

    public function getOwnerIndex(){
        $Owners = Owner::whenSerach()->paginate(10);

        return view('admin.owners.index',compact('Owners'));
    }


    public function ChangeStatus($Owner){
        // Change The Status
        $Owner->ChangeStatus();
        session()->flash('success' , 'Status  Was Change Succesfuly');
        return redirect()->route('owners.index');
    }

    public function editOwner($owner){
        return view('admin.owners.edit' , compact('owner'));
    }

    public function updateOwner($request,  $owner){
        // dd($request , $client);
        try{
            $data = $request->except('_token' , '_method');
            $data['password'] = bcrypt($request->password);
            $owner->update($data);
            session()->flash('success' , 'Update Owners Was Done Succesfuly');
            return redirect()->route('owners.index');
        }catch(Exception $e){
            session()->flash('error' ,  'Some Thing Went Worng ');
            return redirect()->back();
        }
    }

    public function deleteOwner($Owner)
    {
        try{
            $Owner->delete();
            session()->flash('success' , 'Owners  Was Delete Succesfuly');
            return redirect()->route('owners.index');
        }catch(Exception $e){
            session()->flash('error' ,  'Some Thing Went Worng ');
            return redirect()->back();
        }
    }
}