<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Models\BackEnd\MessageTemplate;
use Illuminate\Http\Request;

class MessageTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $register = MessageTemplate::where('id', 1)->first();
        $deposit = MessageTemplate::where('id', 2)->first();
        $withdraw = MessageTemplate::where('id', 3)->first();
        return view('backend.systemsetting.message.create')
            ->with('register', $register)
            ->with('deposit', $deposit)
            ->with('withdraw', $withdraw);
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

        if ($request->ajax()) {
            $register_id = $request->input('register_id');
            $deposit_id = $request->input('deposit_id');
            $withdraw_id = $request->input('withdraw_id');
            if ($register_id) {
                // dd($register_boMailToAdmin,$register_boMailToCus);
                $enable_admin = $request->input('register_enable_admin');
                $enable_cus = $request->input('register_enable_cus');
                $register = MessageTemplate::find($register_id);
                $register->msg_from = $request->input('register_from');
                
                $register->msg_subject_admin = $request->input('register_subToAdmin');
                $register->msg_body_admin = $request->input('register_boMailToAdmin');
                // $register->enable_cus = ($request->has('register_enable_cus') == true) ? 1 : 0;
                // $register->enable_cus = ($request->has('register_enable_cus') == true) ? 1 : 0;
                $register->enable_admin = $enable_admin;
                $register->enable_cus = $enable_cus;
                $register->msg_subject_cus = $request->input('register_subToCus');
                $register->msg_body_cus = $request->input('register_boMailToCus');
                $register->save();
                return response()->json(['title' => trans('trans.success'), 'message' => trans('trans.messageupdatesuccess'), 'status' => 'success']);
            } elseif ($deposit_id) {
                $enable_admin = $request->input('deposit_enable_admin');
                $enable_cus = $request->input('deposit_enable_cus');
                $deposit = MessageTemplate::find($deposit_id);
                // auditoto@yahoo.com
                // dd($request->input('deposit_boMailToAdmin'));
                $deposit->msg_from = $request->input('deposit_from');
                $deposit->enable_admin = $enable_admin;
                $deposit->msg_subject_admin = $request->input('deposit_subToAdmin');
                $deposit->msg_body_admin = $request->input('deposit_boMailToAdmin');
                $deposit->enable_cus = $enable_cus;
                $deposit->msg_subject_cus = $request->input('deposit_subToCus');
                $deposit->msg_body_cus = $request->input('deposit_boMailToCus');
                $deposit->save();
                return response()->json(['title' => trans('trans.success'), 'message' => trans('trans.messageupdatesuccess'), 'status' => 'success']);
            }elseif ($withdraw_id) {
                $enable_admin = $request->input('withdraw_enable_admin');
                $enable_cus = $request->input('withdraw_enable_cus');
                $deposit = MessageTemplate::find($withdraw_id);
                $deposit->msg_from = $request->input('withdraw_from');
                $deposit->enable_admin = $enable_admin;
                $deposit->msg_subject_admin = $request->input('withdraw_subToAdmin');
                $deposit->msg_body_admin = $request->input('withdraw_boMailToAdmin');
                $deposit->enable_cus = $enable_cus;
                $deposit->msg_subject_cus = $request->input('withdraw_subToCus');
                $deposit->msg_body_cus = $request->input('withdraw_boMailToCus');
                $deposit->save();
                return response()->json(['title' => trans('trans.success'), 'message' => trans('trans.messageupdatesuccess'), 'status' => 'success']);
            }
        }
        /*
        $register_id = $request->input('register_id');
        $deposit_id = $request->input('deposit_id');
        $withdraw_id = $request->input('withdraw_id');
        if ($register_id) {
            // dd($request->register_boMailToAdmin);
            $register = MessageTemplate::find($register_id);
            $register->msg_from = $request->register_from;
            $register->msg_subject_admin = $request->register_subToAdmin;
            $register->msg_body_admin = $request->register_boMailToAdmin;
            $register->msg_subject_cus = $request->register_subToCus;
            $register->msg_body_cus = $request->register_boMailToCus;
            $register->enable_admin = ($request->has('register_enable_admin') == true) ? 1 : 0;
            $register->enable_cus = ($request->has('register_enable_cus') == true) ? 1 : 0;
            $register->save();
        } elseif ($deposit_id) {
            // dd($request->all());
            $deposit = MessageTemplate::find($deposit_id);
            $deposit->msg_from = $request->deposit_from;
            $deposit->msg_subject_admin = $request->deposit_subToAdmin;
            $deposit->msg_body_admin = $request->deposit_boMailToAdmin;
            $deposit->msg_subject_cus = $request->deposit_subToCus;
            $deposit->msg_body_cus = $request->deposit_boMailToCus;
            $deposit->enable_admin = ($request->has('deposit_enable_admin') == true) ? 1 : 0;
            $deposit->enable_cus = ($request->has('deposit_enable_cus') == true) ? 1 : 0;
            $deposit->save();
        } else {
            // dd($request->all());
            $withdraw = MessageTemplate::find($withdraw_id);
            $withdraw->msg_from = $request->withdraw_from;
            $withdraw->msg_subject_admin = $request->withdraw_subToAdmin;
            $withdraw->msg_body_admin = $request->withdraw_boMailToAdmin;
            $withdraw->msg_subject_cus = $request->withdraw_subToCus;
            $withdraw->msg_body_cus = $request->withdraw_boMailToCus;
            $withdraw->enable_admin = ($request->has('withdraw_enable_admin') == true) ? 1 : 0;
            $withdraw->enable_cus = ($request->has('withdraw_enable_cus') == true) ? 1 : 0;
            $withdraw->save();
        }
        \Alert::success(trans('menu.messagetemplate') . trans('trans.messageupdatesuccess'), trans('trans.success'));
        if ($request->has('btnsaveclose')) {
            return redirect(_ADMIN_PREFIX_URL . '/messagetemplates');
        } else {
            return redirect(_ADMIN_PREFIX_URL . '/messagetemplates/');
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
