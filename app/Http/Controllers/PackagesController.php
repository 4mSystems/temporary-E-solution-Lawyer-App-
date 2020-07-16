<?php

namespace App\Http\Controllers;

use App\category;
use App\Clients;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Services\DataTable;
use App\Package;

class PackagesController extends Controller
{

    public function index()
    {

//        $user_id = auth()->user()->id;
//        $permission = Permission::where('user_id', $user_id)->first();
//        $enabled = $permission->clients;

//        if ($enabled == 'yes') {
            if (request()->ajax()) {
                    return datatables()->of(Package::latest()->get())
                        ->addColumn('action', function ($data) {
                            $button = '<button data-package-id="' . $data->id . '" id="editPackage" class="btn btn-xs btn-blue tooltips" ><i
                                    class="fa fa-edit"></i>&nbsp;&nbsp;' . trans('site_lang.public_edit_btn_text') . '</button>';
                            $button .= '&nbsp;&nbsp;';

                            $button .= '<button data-package-id="' . $data->id . '" id="deletePackage"  class="btn btn-xs btn-red tooltips" ><i
                                    class="fa fa-times fa fa-white"></i>&nbsp;&nbsp;' . trans('site_lang.public_delete_text') . '</button>';
                            return $button;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
            }
            return view('packages.package');
//        } else {
//            return redirect(url('home'));
//
//        }
    }


    public function create()
    {
        //
    }

    function store(Request $request)
    {

        if (auth()->user()->type == 'User') {
            $data = $this->validate(request(), [
                'name' => 'required',
                'cost' => 'required',
                'duration' => 'required',
            ]);
        } else {
            $data = $this->validate(request(), [
                'name' => 'required',
                'cost' => 'required',
                'duration' => 'required',
            ]);
        }
        Package::create($data);
        return response()->json(['success' => trans('site_lang.public_success_text')]);
    }

    public function show($id)
    {
        //
    }


    public
    function edit($id)
    {
        if (request()->ajax()) {
            $data = Package::findOrFail($id);
            return response()->json(['data' => $data]);
        }
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {

            $data = $this->validate(request(), [
                'name' => 'required',
                'cost' => 'required',
                'duration' => 'required',
            ]);

            Package::find($request->id)->update($data);
            return response(['success' => trans('site_lang.public_success_text')]);
        }
    }


    public function destroy($id)
    {
        $data = Package::findOrFail($id);
        $data->delete();
    }
}
