<?php

namespace App\Repo\Repositories;

use App\Models\Attachments;
use App\Models\Client;
use App\Models\Owner;
use App\Repo\Interfaces\ClientInteface;
use App\Repo\Interfaces\OwnerInterFace;
use Exception;
use Yajra\DataTables\DataTables;

class  OwnerRepository implements OwnerInterFace
{
    public function create()
    {
        return view('admin.owners.create');
    }
    public function StoreOwner($request)
    {
        $this->StoreOwnerInDatabse($request);
        session()->flash('success', __('translation.add_item_successfly'));
        return redirect()->route('owners.index');
    }

    public function StoreOwnerInDatabse($request)
    {
        try {
            $data = $request->all();
            $filterd = collect($data)->except('_token', 'owner_attachment');
            $Owner  = Owner::create($filterd->toArray());
            if ($request->hasFile('owner_attachment')) {
                $filename = $request->owner_attachment->store('owner_attachment');
                // $Owner->attachments()->create([])
                $attachment  = new Attachments();
                // $attachment->attacheable = $agent->id;
                $attachment->url = $filename;
                $Owner->attachments()->save($attachment);
            }
            return $Owner->load('attachments');
        } catch (Exception $e) {
            dd($e);
            // return $e;
        }
    }

    public function getOwnerIndex()
    {
        return view('admin.owners.index');
    }

    public function ShowOwnerData($Owner)
    {
        // return $Owner;
        return view('admin.owners.show', compact('Owner'));
    }
    public function getOwnerData()
    {
        $query = Owner::latest();
        return  DataTables::of($query)
            ->editColumn('created_at', function ($item) {
                return $item->created_at->format('Y-m-d');
            })
            ->editColumn('identification_type', function ($item) {
                return __('translation.' . $item->identification_type);
            })
            ->editColumn('status', function ($item) {
                return  $item->getStatusWithSpan();
            })
            ->editColumn(
                'actions',
                'admin.owners.data_table.actions'
            )
            ->rawColumns(['actions', 'status'])
            ->toJson();
    }


    public function ChangeStatus($Owner)
    {
        // Change The Status
        $Owner->ChangeStatus();
        session()->flash('success', __('translation.Status  Was Change Succesfuly'));
        return redirect()->route('owners.index');
    }

    public function editOwner($owner)
    {
        return view('admin.owners.edit', compact('owner'));
    }

    public function updateOwner($request,  $owner)
    {
        // dd($request , $client);
        try {
            $data = $request->except('_token', '_method');
            $owner->update($data);
            session()->flash('success', __('translation.' . 'Update  Was Done Succesfuly'));
            return redirect()->route('owners.index');
        } catch (Exception $e) {
            session()->flash('error',   __('translation.Some Thing Went Worng'));
            return redirect()->back();
        }
    }

    public function deleteOwner($Owner)
    {
        try {
            $Owner->delete();
            session()->flash('success', __('translation.Delete  Done Succesfuly'));
            return redirect()->route('owners.index');
        } catch (Exception $e) {
            session()->flash('error',  __('translation.Some Thing Went Worng'));
            return redirect()->back();
        }
    }
}