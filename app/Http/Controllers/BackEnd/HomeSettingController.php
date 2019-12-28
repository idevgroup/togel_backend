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
        $record = HomeSetting::where('status',1)->first();
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
        // if($request->ajax()){
            $id = $request->input('id');
         
            if($id){
                $request->validate([
                    'name' => 'required',
                    'address' => 'required',
                    'ipfilter_alias_exception' => 'required',
                    'phone' => 'required'
                ],
                [
                    'name.required' => 'Please Input Name',
                    'address.required' => 'Please Input Address',
                    'ipfilter_alias_exception.required' => 'Please Input Exception Keyword',
                    'phone.required' => 'Please Input Phone number',
                    // 'phone.numeric' => 'This is field input can only number'
                ]);
                $id = $request->id;
                $homesetting = HomeSetting::find($id);
                $homesetting->sc_name = $request->input('name');
                $homesetting->sc_address = $request->input('address');
                $homesetting->sc_phone = $request->input('phone');
                $homesetting->sc_sms = $request->input('sms');
                $homesetting->sc_pinbb = $request->input('pinbb');
                $homesetting->sc_wechat = $request->input('wechat');
                $homesetting->sc_line = $request->input('line');
                $homesetting->sc_facebook = $request->input('facebook');
                $homesetting->sc_twitter = $request->input('twitter');
                $homesetting->sc_google = $request->input('google');
                $homesetting->sc_email = $request->input('mail');
                $homesetting->sc_title = $request->input('title');
                $homesetting->sc_keywords = $request->input('keywords');
                $homesetting->sc_description = $request->input('description');
                $homesetting->sc_ipfilter_alias_exception = $request->input('ipfilter_alias_exception');
                $homesetting->currency = $request->input('currency');
                $homesetting->desc_bottom = $request->input('desc_bottom');
                $homesetting->save();
                // return response()->json(['title' => trans('trans.success'), 'message' => trans('trans.messageupdatesuccess'), 'status' => 'success']);
                \Alert::success(trans('menu.setting') . trans('trans.messageupdatesuccess'), trans('trans.success'));
                if ($request->has('btnsaveclose')) {
                    return redirect(_ADMIN_PREFIX_URL . '/homesettings');
                } else {
                    return redirect(_ADMIN_PREFIX_URL . '/homesettings/');
                }
            }
        // }
        
        /*
        else{
            $request->validate([
                'name' => 'required',
                'address' => 'required',
                'ipfilter_alias_exception' => 'required',
            ],
            [
                'name.required' => 'Please Input Name',
                'address.required' => 'Please Input Address',
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
