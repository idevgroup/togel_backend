<?php

namespace App\Http\Controllers\BackEnd;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BackEnd\GeneralSetting;
use function Opis\Closure\serialize;
use App\Models\BackEnd\MailConfig;
use App\Models\Backend\Language;
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
        $language  = Language::where('status',1)->pluck('name','id')->all();
        return view('backend.systemsetting.generalsetting.create')
        ->with('generalSetting', $generalSetting)
        ->with('mailConfig', $mailConfig)
        ->with('language',$language);
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
       
        $general_id = $request->input('general_id');
        if($general_id){
            //$test = $request->file('logo');
            //dd($test->getFilename(),$request->file('logo'));

            $generalSetting = GeneralSetting::find($general_id);
            $generalSetting->currency = $request->input('currency');
            $generalSetting->timezone = $request->input('timezone');
            $generalSetting->lang = $request->input('lang');
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
