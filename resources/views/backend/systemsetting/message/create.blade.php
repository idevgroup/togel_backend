@extends('backend.template.main') 
@push('title',trans('menu.messagetemplate').'-'.trans('trans.create')) 
@section('content')

<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

    <input type="hidden" id="game_setting_id" name="game_setting_id">
    <div class="m-portlet m-portlet--tabs">
        <div class="m-portlet__head">
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--danger m-tabs-line--2x m-tabs-line--right" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_portlet_base_demo_2_1_tab_content" role="tab">
                            {!! trans('labels.register_mail_templates') !!}           
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_base_demo_2_2_tab_content" role="tab">
                            {!! trans('labels.deposit_mail_templates') !!}
                        </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_base_demo_2_3_tab_content" role="tab">
                            {!! trans('labels.withdraw_mail_templates') !!}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active" id="m_portlet_base_demo_2_1_tab_content" role="tabpanel">
                    {!!Form::open(['class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true])!!} {{-- 'url' =>url(_ADMIN_PREFIX_URL.'/messagetemplates/0'), ,'method'=> 'PATCH' --}}
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <input type="hidden" name="register_id" id="register_id" value="{{$register->id}}">
                            <div class="form-group m-form__group row @if ($errors->has('register_from')) has-danger @endif">
                                {!!Form::label('register_from', trans('labels.from'),['class' => 'col-sm-3 col-form-label'])!!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {!!Form::text('register_from',old('register_from',$register->msg_from),['class' => 'form-control m-input','id'=>'register_from'])!!} @if ($errors->has('register_from'))
                                        <p class="form-control-feedback">{{ $errors->first('register_from') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <label> <input type="checkbox" value="{{$register->enable_admin}}"  name="register_enable_admin" id="register_enable_admin">
                                        <span style="color: #ce8483">{!! trans('labels.enable') !!}</span> {!! trans('labels.send_mail_to_administrator') !!}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('register_subToAdmin')) has-danger @endif">
                                {!!Form::label('register_subToAdmin', trans('labels.subject_to_administrator'),['class' => 'col-sm-3 col-form-label'])!!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {!!Form::text('register_subToAdmin',old('register_subToAdmin',$register->msg_subject_admin),['class' => 'form-control m-input','id'=>'register_subToAdmin'])!!} @if ($errors->has('register_subToAdmin'))
                                        <p class="form-control-feedback">{{ $errors->first('register_subToAdmin') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('register_boMailToAdmin')) has-danger @endif">
                                {!!Form::label('register_boMailToAdmin', trans('labels.body_email_to_administrator'),['class' => 'col-sm-3 col-form-label'])!!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {{-- ,$register->msg_body_admin )?old('register_boMailToAdmin') : (!empty($register)? $register->msg_body_admin : null --}} {!!Form::textarea('register_boMailToAdmin',old($register->msg_body_admin,$register->msg_body_admin),['rows' => 8,'class' => 'form-control
                                        m-input cms-editor','id'=>'register_boMailToAdmin'])!!} @if ($errors->has('register_boMailToAdmin'))
                                        <p class="form-control-feedback">{{ $errors->first('register_boMailToAdmin') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <label> <input type="checkbox" value="{{$register->enable_cus}}"  name="register_enable_cus" id="register_enable_cus" >
                                        <span style="color: #ce8483">{!! trans('labels.enable') !!}</span> {{ trans('labels.send_mailto_customer')}}
                                    </label>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('register_subToCus')) has-danger @endif">
                                {!!Form::label('register_subToCus', trans('labels.subject_to_customer'),['class' => 'col-sm-3 col-form-label'])!!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {!!Form::text('register_subToCus',old('register_subToCus',$register->msg_subject_cus),['class' => 'form-control m-input','id'=>'register_subToCus'])!!} @if ($errors->has('register_subToCus'))
                                        <p class="form-control-feedback">{{ $errors->first('register_subToCus') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('register_boMailToCus')) has-danger @endif">
                                {!!Form::label('register_boMailToCus', trans('labels.body_email_to_customer'),['class' => 'col-sm-3 col-form-label'])!!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {!!Form::textarea('register_boMailToCus',old('register_boMailToCus',$register->msg_body_cus),['rows' => 8,'class' => 'form-control m-input cms-editor'])!!} @if ($errors->has('register_boMailToCus'))
                                        <p class="form-control-feedback">{{ $errors->first('register_boMailToCus') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    {{-- <button type="submit" name="btnsaverefresh" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                            <span>
                                                <i class="fa fa-archive"></i>
                                                <span>{{__('trans.btnsave')}}</span>
                                            </span>
                                        </button> --}}
                                    <button type="button" name="btnsavecloseregister" id="btnsavecloseregister" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                            <span>
                                                <i class="fa fa-archive"></i>
                                                <span>{{__('trans.btnsave')}}</span>
                                            </span>
                                        </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-none d-sm-none d-md-block">
                            <h3 style="text-align: center;">{!! trans('labels.parameters_guids') !!}</h3>
                            <hr>
                            <p>{!! trans('labels.you_can_config_your_mail_body_with_the_following_commands') !!}</p>
                            <ul>
                                <li class="li-bottom"><strong>{ {!! trans('labels.name') !!} }</strong> : {!! trans('labels.customer_name') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.yahoo') !!} }</strong> : {!! trans('labels.yahoo_id') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.email') !!} }</strong> : {!! trans('labels.email') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.phone') !!} }</strong> : {!! trans('labels.phone_number') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.ref') !!} }</strong> : {!! trans('labels.reference') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.game') !!} }</strong> : {!! trans('labels.game_product') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.bank') !!} }</strong> : {!! trans('labels.Bank') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.accName') !!} }</strong> : {!! trans('labels.account_name') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.accNum') !!} }</strong> : {!! trans('labels.account_number') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.msg') !!} }</strong> : {!! trans('labels.message') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.ip') !!} }</strong> : {!! trans('labels.ip_address') !!}</li>
                            </ul>
                        </div>
                    </div>
                    {!!Form::close()!!}
                </div>

                <div class="tab-pane" id="m_portlet_base_demo_2_2_tab_content" role="tabpanel">
                    {!!Form::open(['class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true])!!} {{-- 'url' =>url(_ADMIN_PREFIX_URL.'/messagetemplates/0'), ,'method'=> 'PATCH' --}}
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <input type="hidden" name="deposit_id" id="deposit_id" value="{{$deposit->id}}">
                            <div class="form-group m-form__group row @if ($errors->has('deposit_from')) has-danger @endif">
                                {!!Form::label('deposit_from', trans('labels.from'),['class' => 'col-sm-3 col-form-label '])!!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {!!Form::text('deposit_from',old('deposit_from', $deposit->msg_from),['class' => 'form-control m-input','id'=>'deposit_from'])!!} @if ($errors->has('deposit_from'))
                                        <p class="form-control-feedback">{{ $errors->first('deposit_from') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <label> <input type="checkbox" value="{{$deposit->enable_admin}}" {{($deposit->enable_admin) ? 'checked' : ''}} name="deposit_enable_admin" id="deposit_enable_admin">
                                            <span style="color: #ce8483">{!! trans('labels.enable') !!}</span> {!! trans('labels.send_mail_to_administrator') !!}
                                        </label>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('deposit_subToAdmin')) has-danger @endif">
                                {!!Form::label('deposit_subToAdmin', trans('labels.subject_to_administrator'),['class' => 'col-sm-3 col-form-label '])!!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {!!Form::text('deposit_subToAdmin',old('deposit_subToAdmin',$deposit->msg_subject_admin),['class' => 'form-control m-input','id'=>'deposit_subToAdmin'])!!} @if ($errors->has('deposit_subToAdmin'))
                                        <p class="form-control-feedback">{{ $errors->first('deposit_subToAdmin') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('deposit_boMailToAdmin')) has-danger @endif">
                                {!!Form::label('deposit_boMailToAdmin', trans('labels.body_email_to_administrator'),['class' => 'col-sm-3 col-form-label '])!!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {!!Form::textarea('deposit_boMailToAdmin',old('deposit_boMailToAdmin',$deposit->msg_body_admin),['rows' => 8,'class' => 'form-control m-input cms-editor'])!!} @if ($errors->has('deposit_boMailToAdmin'))
                                        <p class="form-control-feedback">{{ $errors->first('deposit_boMailToAdmin') }}</p> @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <label> <input type="checkbox" name="deposit_enable_cus" id="deposit_enable_cus" value="{{$deposit->enable_cus}}" {{($deposit->enable_cus) ? 'checked' : ''}}>
                                            <span style="color: #ce8483">{!! trans('labels.enable') !!}</span> {!! trans('labels.send_mailto_customer') !!}
                                        </label>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('deposit_subToCus')) has-danger @endif">
                                {!!Form::label('deposit_subToCus', trans('labels.subject_to_customer'),['class' => 'col-sm-3 col-form-label '])!!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {!!Form::text('deposit_subToCus',old('deposit_subToCus',$deposit->msg_subject_cus),['class' => 'form-control m-input','id'=>'deposit_subToCus'])!!} @if ($errors->has('deposit_subToCus'))
                                        <p class="form-control-feedback">{{ $errors->first('deposit_subToCus') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('deposit_boMailToCus')) has-danger @endif">
                                {!!Form::label('deposit_boMailToCus',trans('labels.subject_to_customer'),['class' => 'col-sm-3 col-form-label '])!!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {!!Form::textarea('deposit_boMailToCus',old('deposit_boMailToCus',$deposit->msg_body_cus),['rows' => 8,'class' => 'form-control m-input cms-editor'])!!} @if ($errors->has('deposit_boMailToCus'))
                                        <p class="form-control-feedback">{{ $errors->first('deposit_boMailToCus') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    {{-- <button type="submit" name="btnsaverefresh" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                                                <span>
                                                                    <i class="fa fa-archive"></i>
                                                                    <span>{{__('trans.btnsave')}}</span>
                                                                </span>
                                                            </button> --}}
                                    <button type="button" name="btnsaveclosedeposit" id="btnsaveclosedeposit" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                                                    <span>
                                                                        <i class="fa fa-archive"></i>
                                                                        <span>{{__('trans.btnsave')}}</span>
                                                                    </span>
                                                                </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-none d-sm-none d-md-block">
                            <h3 style="text-align: center;">{!! trans('labels.parameters_guids') !!}</h3>
                            <hr>
                            <p>{!! trans('labels.you_can_config_your_mail_body_with_the_following_commands') !!}</p>
                            <ul>
                                <li class="li-bottom"><strong>{ {!! trans('labels.name') !!} }</strong> : {!! trans('labels.customer_name') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.yahoo') !!} }</strong> : {!! trans('labels.yahoo_id') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.email') !!} }</strong> : {!! trans('labels.email') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.phone') !!} }</strong> : {!! trans('labels.phone_number') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.ref') !!} }</strong> : {!! trans('labels.reference') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.game') !!} }</strong> : {!! trans('labels.game_product') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.bank') !!} }</strong> : {!! trans('labels.Bank') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.accName') !!} }</strong> : {!! trans('labels.account_name') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.accNum') !!} }</strong> : {!! trans('labels.account_number') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.msg') !!} }</strong> : {!! trans('labels.message') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.ip') !!} }</strong> : {!! trans('labels.ip_address') !!}</li>
                            </ul>
                        </div>
                    </div>
                    {!!Form::close()!!}
                </div>





                <div class="tab-pane" id="m_portlet_base_demo_2_3_tab_content" role="tabpanel">
                    {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/messagetemplates/0'), 'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method'=> 'PATCH'])!!}
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <input type="hidden" name="withdraw_id" id="withdraw_id" value="{{$withdraw->id}}">
                            <div class="form-group m-form__group row @if ($errors->has('withdraw_from')) has-danger @endif">
                                {!!Form::label('withdraw_from', trans('labels.from'),['class' => 'col-sm-3 col-form-label '])!!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {!!Form::text('withdraw_from',old('withdraw_from',$withdraw->msg_from),['class' => 'form-control m-input','id'=>'withdraw_from'])!!} @if ($errors->has('withdraw_from'))
                                        <p class="form-control-feedback">{{ $errors->first('withdraw_from') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <label> <input type="checkbox" name="withdraw_enable_admin" id="withdraw_enable_admin" value="{{$withdraw->enable_admin}}" {{($withdraw->enable_admin) ? 'checked' : ''}}><span style="color: #ce8483">Enable</span> Send mail to Administrator</label>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('withdraw_subToAdmin')) has-danger @endif">
                                {!!Form::label('withdraw_subToAdmin', trans('labels.subject_to_administrator'),['class' => 'col-sm-3 col-form-label '])!!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {!!Form::text('withdraw_subToAdmin',old('withdraw_subToAdmin',$withdraw->msg_subject_admin),['class' => 'form-control m-input','id'=>'withdraw_subToAdmin'])!!} @if ($errors->has('withdraw_subToAdmin'))
                                        <p class="form-control-feedback">{{ $errors->first('withdraw_subToAdmin') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('withdraw_boMailToAdmin')) has-danger @endif">
                                {!!Form::label('withdraw_boMailToAdmin', trans('labels.body_email_to_administrator'),['class' => 'col-sm-3 col-form-label '])!!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {!!Form::textarea('withdraw_boMailToAdmin',old('withdraw_boMailToAdmin',$withdraw->msg_body_admin),['rows' => 8,'class' => 'form-control m-input cms-editor'])!!} @if ($errors->has('withdraw_boMailToAdmin'))
                                        <p class="form-control-feedback">{{ $errors->first('withdraw_boMailToAdmin') }}</p> @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <label> <input type="checkbox" name="withdraw_enable_cus" id="withdraw_enable_cus" value="{{$withdraw->enable_cus}}" {{($withdraw->enable_cus) ? 'checked' : ''}}>
                                            <span style="color: #ce8483">{!! trans('labels.enable') !!}</span> {!! trans('labels.send_mailto_customer') !!}</label>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('withdraw_subToCus')) has-danger @endif">
                                {!!Form::label('withdraw_subToCus', trans('labels.subject_to_customer'),['class' => 'col-sm-3 col-form-label '])!!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {!!Form::text('withdraw_subToCus',old('withdraw_subToCus',$withdraw->msg_subject_cus),['class' => 'form-control m-input','id'=>'withdraw_subToCus'])!!} @if ($errors->has('withdraw_subToCus'))
                                        <p class="form-control-feedback">{{ $errors->first('withdraw_subToCus') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('withdraw_boMailToCus')) has-danger @endif">
                                {!!Form::label('withdraw_boMailToCus',trans('labels.subject_to_customer'),['class' => 'col-sm-3 col-form-label '])!!}
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        {!!Form::textarea('withdraw_boMailToCus',old('withdraw_boMailToCus',$withdraw->msg_body_cus),['rows' => 8,'class' => 'form-control m-input cms-editor'])!!} @if ($errors->has('withdraw_boMailToCus'))
                                        <p class="form-control-feedback">{{ $errors->first('withdraw_boMailToCus') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <!-- <button type="submit" name="btnsaverefresh" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                                                <span>
                                                                    <i class="fa fa-archive"></i>
                                                                    <span>{{__('trans.btnsave')}}</span>
                                                                </span>
                                                            </button> -->
                                    <button type="button" name="btnsaveclosewithdraw" id="btnsaveclosewithdraw" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                                                <span>
                                                                    <i class="fa fa-archive"></i>
                                                                    <span>{{__('trans.btnsave')}}</span>
                                                                </span>
                                                            </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 d-none d-sm-none d-md-block">
                            <h3 style="text-align: center;">{!! trans('labels.parameters_guids') !!}</h3>
                            <hr>
                            <p>{!! trans('labels.you_can_config_your_mail_body_with_the_following_commands') !!}</p>
                            <ul>
                                <li class="li-bottom"><strong>{ {!! trans('labels.name') !!} }</strong> : {!! trans('labels.customer_name') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.yahoo') !!} }</strong> : {!! trans('labels.yahoo_id') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.email') !!} }</strong> : {!! trans('labels.email') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.phone') !!} }</strong> : {!! trans('labels.phone_number') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.ref') !!} }</strong> : {!! trans('labels.reference') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.game') !!} }</strong> : {!! trans('labels.game_product') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.bank') !!} }</strong> : {!! trans('labels.Bank') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.accName') !!} }</strong> : {!! trans('labels.account_name') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.accNum') !!} }</strong> : {!! trans('labels.account_number') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.msg') !!} }</strong> : {!! trans('labels.message') !!}</li>
                                <li class="li-bottom"><strong>{ {!! trans('labels.ip') !!} }</strong> : {!! trans('labels.ip_address') !!}</li>
                            </ul>
                        </div>
                    </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection @push('style')
<link rel="stylesheet" href="{{asset('backend/assets/fileinput/fileinput.css')}}" />
<link rel="stylesheet" href="{{asset('backend/assets/tagsinput/tagsinput.css')}}" />
<style>
    .bootstrap-tagsinput .badge {
        margin: 2px 2px;
        padding: 5px 8px;
        font-size: 12px;
    }
    
    .bootstrap-tagsinput .badge [data-role="remove"] {
        margin-left: 10px;
        cursor: pointer;
        color: #99334a;
    }
    
    .bootstrap-tagsinput .badge [data-role="remove"]:after {
        content: "×";
        padding: 0px 4px;
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        font-size: 14px;
    }
    
    .font-size {
        font-size: 11px;
    }
    
    .li-bottom {
        padding-bottom: 8px;
    }
</style>
@endpush @push('javascript') {{--
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>--}}
<script type="text/javascript" src="{{ asset('backend/assets/jquery.furl.js')}}"></script>
<script type="text/javascript" charset="utf8" src="{{asset('backend/assets/tagsinput/tagsinput.js')}}"></script>
{{--{!!JsValidator::formRequest('App\Http\Requests\CategoriesRequest', '#idev-form')!!}--}} @include('backend.shared._selectimg',['selectElement' => '#banner']) @include('backend.shared._tinymce',['elements' => '.cms-editor'])
<script type="text/javascript">
    var BootstrapSwitch = {
        init: function() {
            $("[data-switch=true]").bootstrapSwitch()
        }
    };
    jQuery(document).ready(function() {
        BootstrapSwitch.init();
        var RegEnAdmin = $('#register_enable_admin').val();
        var classRegEnAdmin = $('#register_enable_admin');
        var RegEnCus = $('#register_enable_cus').val();
        var classRegEnCus = $('#register_enable_cus');
        enable(RegEnAdmin, classRegEnAdmin);
        enable(RegEnCus, classRegEnCus);


        var depositEnAdmin = $('#deposit_enable_admin').val();
        var classdepositEnAdmin = $('#deposit_enable_admin');
        var depositEnCus = $('#deposit_enable_cus').val();
        var classdepositEnCus = $('#deposit_enable_cus');
        enable(depositEnAdmin, classdepositEnAdmin);
        enable(depositEnCus, classdepositEnCus);
        // if (status == 1) {
        //     $('#register_enable_admin').prop('checked', true);
        // } else {
        //     $('#register_enable_admin').prop('checked', false);
        // }
        // if (status2 == 1) {
        //     $('#register_enable_cus').prop('checked', true);
        // } else {
        //     $('#register_enable_cus').prop('checked', false);
        // }
    });

    function enable($enable, $class) {
        if ($enable == 1) {
            $($class).prop('checked', true);
        } else {
            $($class).prop('checked', false);
        }
    }
    $(function() {
        $('body').on('click', '#btnsavecloseregister', function() {
                tinyMCE.triggerSave();
                //register
                var register_id = $('#register_id').val();
                var register_from = $('#register_from').val();
                var register_enable_admin = $('#register_enable_admin').is(":checked") ? 1 : 0;
                var register_subToAdmin = $('#register_subToAdmin').val();
                var register_boMailToAdmin = $('#register_boMailToAdmin').val();
                var register_subToCus = $('#register_subToCus').val();
                var register_boMailToCus = $('#register_boMailToCus').val();
                var register_enable_cus = $('#register_enable_cus').is(":checked") ? 1 : 0;
                //var register_enable_cus = $('#register_enable_cus').val();
                //console.log(register_enable_admin, register_enable_cus);
                $.ajax({
                    url: '{{url(_ADMIN_PREFIX_URL."/messagetemplates/0")}}',
                    method: 'PATCH',
                    dataType: 'JSON',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        //register
                        register_id,
                        register_from,
                        register_enable_admin,
                        register_subToAdmin,
                        register_boMailToAdmin,
                        register_enable_cus,
                        register_subToCus,
                        register_boMailToCus
                    },
                    success: function(response) {
                        swal({
                            title: response.title,
                            html: response.message,
                            type: response.status,
                            allowOutsideClick: false,
                            timer: 1500
                        });
                    }
                })
            })
            //deposit
        $('body').on('click', '#btnsaveclosedeposit', function() {
            tinyMCE.triggerSave();
            var deposit_id = $('#deposit_id').val();
            var deposit_from = $('#deposit_from').val();
            var deposit_enable_admin = $('#deposit_enable_admin').is(":checked") ? 1 : 0;
            var deposit_subToAdmin = $('#deposit_subToAdmin').val();
            var deposit_boMailToAdmin = $('#deposit_boMailToAdmin').val();
            var deposit_enable_cus = $('#deposit_enable_cus').is(":checked") ? 1 : 0;
            var deposit_subToCus = $('#deposit_subToCus').val();
            var deposit_boMailToCus = $('#deposit_boMailToCus').val();
            $.ajax({
                url: '{{url(_ADMIN_PREFIX_URL."/messagetemplates/0")}}',
                method: 'PATCH',
                dataType: 'JSON',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    //deposit
                    deposit_id,
                    deposit_from,
                    deposit_enable_admin,
                    deposit_subToAdmin,
                    deposit_boMailToAdmin,
                    deposit_enable_cus,
                    deposit_subToCus,
                    deposit_boMailToCus
                },
                success: function(response) {
                    swal({
                        title: response.title,
                        html: response.message,
                        type: response.status,
                        allowOutsideClick: false,
                        timer: 1500
                    });
                }
            })
        })

        //deposit
        $('body').on('click', '#btnsaveclosewithdraw', function() {
            tinyMCE.triggerSave();
            var withdraw_id = $('#withdraw_id').val();
            var withdraw_from = $('#withdraw_from').val();
            var withdraw_enable_admin = $('#withdraw_enable_admin').is(":checked") ? 1 : 0;
            var withdraw_subToAdmin = $('#withdraw_subToAdmin').val();
            var withdraw_boMailToAdmin = $('#withdraw_boMailToAdmin').val();
            var withdraw_enable_cus = $('#withdraw_enable_cus').is(":checked") ? 1 : 0;
            var withdraw_subToCus = $('#withdraw_subToCus').val();
            var withdraw_boMailToCus = $('#withdraw_boMailToCus').val();
            $.ajax({
                url: '{{url(_ADMIN_PREFIX_URL."/messagetemplates/0")}}',
                method: 'PATCH',
                dataType: 'JSON',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    //deposit
                    withdraw_id,
                    withdraw_from,
                    withdraw_enable_admin,
                    withdraw_subToAdmin,
                    withdraw_boMailToAdmin,
                    withdraw_enable_cus,
                    withdraw_subToCus,
                    withdraw_boMailToCus
                },
                success: function(response) {
                    swal({
                        title: response.title,
                        html: response.message,
                        type: response.status,
                        allowOutsideClick: false,
                        timer: 1500
                    });
                }
            })
        })

        // $('#register_enable_admin').click(function() {
        //     if ($(this).prop("checked") == true) {
        //         $(this).removeAttr('checked');
        //     } else if ($(this).prop("checked") == false) {
        //         $(this).attr('checked', true);
        //     }
        // });
        // $('#register_enable_cus').click(function() {
        //     if ($(this).prop("checked") == true) {
        //         $(this).removeAttr('checked');
        //     } else if ($(this).prop("checked") == false) {
        //         $(this).attr('checked', true);
        //     }
        // });
    })
</script>
@endpush