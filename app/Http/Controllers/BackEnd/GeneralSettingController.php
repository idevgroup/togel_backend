<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\GeneralSetting;

class GeneralSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $generalSetting = GeneralSetting::all();
        return view('backend.systemsetting.generalsetting.create')->with('generalSetting', $generalSetting);
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
     * @return \Illuminate\Http\Responselogo
     */
    public function update(Request $request, $id)
    {
        /*
        if (request()->ajax()) {
            // dd($request->all());
            if ($id) {
                // dd($request->all());
            }else {
                // dd($request->all());
                $generalSetting = new GeneralSetting;
                $generalSetting->currency = $request->input('currency');
                dd($request->all());
                // if($request->input('logo'))
                // {
                //     // dd($request->input('logo'));
                //     $generalSetting->uploadImage($request->input('logo'));
                // }
                // if($request->input('icon'))
                // {
                //     // dd($request->input('logo'));
                //     $generalSetting->uploadImage($request->input('icon'));
                // }
                $generalSetting->save();
                return response()->json(['title' => trans('trans.success'), 'message' => trans('trans.messageupdatesuccess'), 'status' => 'success']);
            }
        }
        */
       
        $id = $request->id;
        if($id){
            $generalSetting = GeneralSetting::find($id);
            $generalSetting->currency = $request->input('currency');
            if ($request->hasFile('logo')) {
                $generalSetting->uploadImage($request->file('logo'));
            }
            if ($request->hasFile('icon')) {
                $generalSetting->uploadImage($request->file('icon'));
            }
            $generalSetting->save();
            \Alert::success(trans('menu.category') . trans('trans.messageupdatesuccess'), trans('trans.success'));
            if ($request->has('btnsaveclose')) {
                return redirect(_ADMIN_PREFIX_URL . '/generalsettings');
            } 
        }else{
            $generalSetting = new GeneralSetting;
            $generalSetting->currency = $request->input('currency');
            if ($request->hasFile('logo')) {
                $generalSetting->uploadImage($request->file('logo'));
            }
            if ($request->hasFile('icon')) {
                $generalSetting->uploadImage($request->file('icon'));
            }
            $generalSetting->save();
            \Alert::success(trans('menu.category') . trans('trans.messageupdatesuccess'), trans('trans.success'));
            if ($request->has('btnsaveclose')) {
                return redirect(_ADMIN_PREFIX_URL . '/generalsettings');
            } 
        }
        
        /*else {
            return redirect(_ADMIN_PREFIX_URL . '/generalsettings/');
        }
        */
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
