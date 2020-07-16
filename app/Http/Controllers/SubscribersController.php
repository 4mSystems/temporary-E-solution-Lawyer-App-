<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class SubscribersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $subscribers = User::where('parent_id',null)->get();
        if (request()->ajax()) {
            return datatables()->of(User::where('parent_id', null)->get())
                ->addColumn('action', function ($data) {
                    $button = '<button  data-sub-id="' . $data->id . '" id="editsub" class="btn btn-xs btn-green tooltips" ><i
                            class="fa fa-edit"></i>&nbsp;&nbsp;' . trans('site_lang.edit') . '</button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a  data-sub-id="' . $data->id . '" id="deletesub" class="btn btn-xs btn-red tooltips" ><i
                            class="fa fa-trash"></i>&nbsp;&nbsp;' . trans('site_lang.delete') . '</a>';
                    return $button;
                })->rawColumns(['action'])->make(true);
        }

        return view('Subscribers/subscribers');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
