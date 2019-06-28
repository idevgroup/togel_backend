<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\controllers\controller;
use App\Models\BackEnd\HomeSetting;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Mail\Message;

class HomeSettingController extends Controller
{
    use Authorizable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $record = HomeSetting::where('status',1)->get();
        return view('backend.systemsetting.homesetting.create')->with('record',$record);
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
        // dd($request->all());
        
        if($request->has('id')){
            $id = $request->id;
            $homesetting = HomeSetting::find($id);
            $homesetting->sc_name = $request->name;
            $homesetting->sc_address = $request->address;
            $homesetting->sc_phone = $request->phone;
            $homesetting->sc_sms = $request->sms;
            $homesetting->sc_pinbb = $request->pinbb;
            $homesetting->sc_wechat = $request->wechat;
            $homesetting->sc_line = $request->line;
            $homesetting->sc_facebook = $request->facebook;
            $homesetting->sc_twitter = $request->twitter;
            $homesetting->sc_google = $request->google;
            $homesetting->sc_email = $request->mail;
            $homesetting->sc_title = $request->title;
            $homesetting->sc_keywords = $request->keywords;
            $homesetting->sc_description = $request->description;
            $homesetting->sc_ipfilter_alias_exception = $request->ipfilter_alias_exception;
            $homesetting->save();
            \Alert::success(trans('menu.setting') . trans('trans.messageupdatesuccess'), trans('trans.success'));
            if ($request->has('btnsaveclose')) {
                return redirect(_ADMIN_PREFIX_URL . '/homesettings');
            } else {
                return redirect(_ADMIN_PREFIX_URL . '/homesettings/');
            }
        }else{


            $request->validate([
                'name' => 'required',
                'Adress' => 'required',
                'ipfilter_alias_exception' => 'required',
            ],
            [
                'name.required' => 'Please Input Name',
                'Adress.required' => 'Please Input Address',
                'ipfilter_alias_exception.required' => 'Please Input Exception Keyword']);


            $homesetting = new HomeSetting;
            $homesetting->sc_name = $request->name;
            $homesetting->sc_address = $request->address;
            $homesetting->sc_phone = $request->phone;
            $homesetting->sc_sms = $request->sms;
            $homesetting->sc_pinbb = $request->pinbb;
            $homesetting->sc_wechat = $request->wechat;
            $homesetting->sc_line = $request->line;
            $homesetting->sc_facebook = $request->facebook;
            $homesetting->sc_twitter = $request->twitter;
            $homesetting->sc_google = $request->google;
            $homesetting->sc_email = $request->mail;
            $homesetting->sc_title = $request->title;
            $homesetting->sc_keywords = $request->keywords;
            $homesetting->sc_description = $request->description;
            $homesetting->sc_ipfilter_alias_exception = $request->ipfilter_alias_exception;
            $homesetting->save();
            \Alert::success(trans('menu.setting') . trans('trans.messageaddsuccess'), trans('trans.success'));
            if ($request->has('btnsaveclose')) {
                return redirect(_ADMIN_PREFIX_URL . '/homesettings');
            } else {
                return redirect(_ADMIN_PREFIX_URL . '/homesettings/');
            }
        }
        
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
