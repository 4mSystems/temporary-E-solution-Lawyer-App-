<?php

namespace App\Http\Controllers;

use App\Sessions;
use Illuminate\Http\Request;
use App\User;
use App\category;
use App\package;
use App\Clients;

class SubscribersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {

            return datatables()->of(User::where('parent_id',null)->where('type','!=','manager')->get())
                ->addColumn('status', function ($data) {
                    if ($data->status == trans('site_lang.statusDeactive')) {
                        $html = '<p class="btn btn-sm" data-user-id="' . $data->id . '" id="change-user-status">
                            <span class="label label-danger text-bold"> ' . $data->status . '</span></p>';
                    }else if ($data->status == trans('site_lang.statusDemo'))  {
                        $html = '<p class="btn btn-sm" data-user-Id="' . $data->id . '" id="change-user-status">
                            <span class="label label-warning text-bold"> ' . $data->status . '</span></p>';
                    } else {
                        $html = '<p class="btn btn-sm" data-user-Id="' . $data->id . '" id="change-user-status">
                            <span class="label label-success text-bold"> ' . $data->status . '</span></p>';
                    }

                    return $html;
                }) ->addColumn('action', function ($data) {
                    $button = '<button data-client-id="' . $data->id . '" id="editClient" class="btn btn-xs btn-blue tooltips" ><i
                                    class="fa fa-edit"></i>&nbsp;&nbsp;' . trans('site_lang.public_edit_btn_text') . '</button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button data-client-id="' . $data->id . '" id="deleteClient"  class="btn btn-xs btn-red tooltips" ><i
                                    class="fa fa-times fa fa-white"></i>&nbsp;&nbsp;' . trans('site_lang.public_delete_text') . '</button>';
                    return $button;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }

        $packages = Package::all();
        return view('Subscribers.subscribers',compact('packages'));
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
    // update session status from waiting to done
    public function updateStatus($id)
    {
        $status = false;
        $user = User::find($id);
        if ($user->status == trans('site_lang.statusDemo')) {
            $user->status = "Active";
            $status = true;
        } else if ($user->status== trans('site_lang.statusDeactive')){
            $user->status = "Active";
            $status = true;
        }else{
            $user->status = "Deactive";
            $status = false;
        }
        $user->update();
        return response(['msg' => trans('site_lang.public_success_text'), 'status' => $status]);

    }
    public function store(Request $request)
    {
            $data = $this->validate(request(), [
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
                'phone' => 'required',
                'address' => 'required',
                'cat_name' => 'required',
                'package_id' => 'required',

            ]);

        $Cat_data['name']=  $request->cat_name;
        $category= category::create($Cat_data);

        $data['cat_id'] =$category->id;
        $data['status'] ='Active';
        $data['type'] ='admin';
       $user_result= User::create($data);

        $category->parent_id = $user_result->id;
        $category->update();

        return response()->json(['success' => trans('site_lang.public_success_text')]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (request()->ajax()) {
            $data = User::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
