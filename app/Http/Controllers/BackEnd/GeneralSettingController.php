<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\GeneralSetting;
use function Opis\Closure\serialize;
use App\Models\BackEnd\MailConfig;

class GeneralSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $generalSetting = GeneralSetting::first();
        $mailConfig = MailConfig::first();
        return view('backend.systemsetting.generalsetting.create')
        ->with('generalSetting', $generalSetting)
        ->with('mailConfig', $mailConfig);
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
       \Log::info($request->all());
        // dd($request->input('id'),$request->input('currency'));
        if (request()->ajax()) {
            // dd($request->all());
             $id = $request->input('id');
           
             if($id){
                $generalSetting = GeneralSetting::find($id);
                $generalSetting->currency = $request->input('currency');
                $generalSetting->timezone = $request->input('timezone');
                if($request->hasFile('logo')){
                    $generalSetting->uploadImage($request->file('logo'));
                }
                if ($request->hasFile('icon')) {
                    $generalSetting->uploadImage($request->file('icon'));
                }
                // dd($request->input('logo'));
                $generalSetting->save();
                return response()->json(['title' => trans('trans.success'), 'message' => trans('trans.messageupdatesuccess'), 'status' => 'success']);
             }
             else{
                $generalSetting = new GeneralSetting;
                $generalSetting->currency = $request->input('currency');
                $generalSetting->timezone = $request->input('timezone');
                if($request->hasFile('logo')){
                    $generalSetting->uploadImage($request->file('logo'));
                }
                if ($request->hasFile('icon')) {
                    $generalSetting->uploadImage($request->file('icon'));
                }
                // dd($request->input('logo'));
                $generalSetting->save();
                return response()->json(['title' => trans('trans.success'), 'message' => trans('trans.messageupdatesuccess'), 'status' => 'success']);
             }
        }
        */
        $general_id = $request->input('general_id');
        if($general_id){
            //$test = $request->file('logo');
            //dd($test->getFilename(),$request->file('logo'));

            $generalSetting = GeneralSetting::find($general_id);
            $generalSetting->currency = $request->input('currency');
            $generalSetting->timezone = $request->input('timezone');
            if ($request->hasFile('logo')) {
                $generalSetting->uploadImage($request->file('logo'));
            }
            if ($request->hasFile('icon')) {
                $generalSetting->uploadImage($request->file('icon'));
            }
            $generalSetting->save();
            \Alert::success(trans('menu.generalsetting') . trans('trans.messageupdatesuccess'), trans('trans.success'));
            if ($request->has('btnsavecloseGeneral')) {
                return redirect(_ADMIN_PREFIX_URL . '/generalsettings');
            } 
        }
        /*
        else{
            $generalSetting = new GeneralSetting;
            $generalSetting->currency = $request->input('currency');
            $generalSetting->timezone = $request->input('timezone');
            if ($request->hasFile('logo')) {
                $generalSetting->uploadImage($request->file('logo'));
            }
            if ($request->hasFile('icon')) {
                $generalSetting->uploadImage($request->file('icon'));
            }
            $generalSetting->save();
            \Alert::success(trans('menu.generalsetting') . trans('trans.messageupdatesuccess'), trans('trans.success'));
            if ($request->has('btnsaveclose')) {
                return redirect(_ADMIN_PREFIX_URL . '/generalsettings');
            } 
        }
        // dd($request->all());
        
         "mailFromName" => "lyhuoth"
        "mailFromAddress" => "kov.lyhuoth@outlook.com"
        "smtp" => "POP3"
        "mailHost" => "smtp.mailtrap.io"
        "mailPort" => "2525"
        "mailUserName" => "lyhuoth"
        "mailPassword" => "lyhuoth123456789"
        "timezone" => "tls"
        "btnsavecloseGeneral" => null
        */
        // dd($request->mailConfig_id);
        $mailConfig_id = $request->input('mailConfig_id');
        if($mailConfig_id){
            $mailconfig = MailConfig::find($mailConfig_id);
            $mailconfig->mail_name = $request->input('mailFromName');
            $mailconfig->mail_address = $request->input('mailFromAddress');
            $mailconfig->mail_smtp = $request->input('smtp');
            $mailconfig->mail_host = $request->input('mailHost');
            $mailconfig->mail_port = $request->input('mailPort');
            $mailconfig->mail_username = $request->input('mailUserName');
            $mailconfig->mail_password = $request->input('mailPassword');
            $mailconfig->mail_encryption = $request->input('mailEncryption');
            $mailconfig->save();
            \Alert::success(trans('menu.mailconfig') . trans('trans.messageupdatesuccess'), trans('trans.success'));
                if ($request->has('btnsavecloseMailConfig')) {
                    return redirect(_ADMIN_PREFIX_URL . '/generalsettings');
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
