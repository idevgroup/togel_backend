@extends('backend.template.main') @push('title',trans('menu.generalsetting').'-'.trans('trans.create')) @section('content')

<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

    <input type="hidden" id="game_setting_id" name="game_setting_id">
    <div class="m-portlet m-portlet--tabs">
        <div class="m-portlet__head">
            <div class="m-portlet__head-tools">
                <ul class="nav nav-tabs m-tabs-line m-tabs-line--danger m-tabs-line--2x m-tabs-line--right" role="tablist">
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_portlet_base_demo_2_1_tab_content" role="tab">
                                        General Setting
                                </a>
                    </li>
                    <li class="nav-item m-tabs__item">
                        <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_base_demo_2_2_tab_content" role="tab">
                                        Mail Configuration
                                </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="tab-content">
                <div class="tab-pane active" id="m_portlet_base_demo_2_1_tab_content" role="tabpanel">
                    {{-- 'url' =>url(_ADMIN_PREFIX_URL.'/messagetemplates/0'), ,'method'=> 'PATCH' --}} {{-- @php($getCurrentCode =Config('sysconfig.currency_code'))
                    {{-- {{dd($getCurrentCode)}} --}}
                        <?php $getCurrentCode =Config('sysconfig.currency_code') ?> 
                        @php($timezones = Config('sysconfig.timezones')) {{-- {{dd($timezones)}} --}} 
                            @if (!$generalSetting->isEmpty()) 
                                {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/generalsettings/0'), 'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method'=> 'PATCH'])!!} 
                                @foreach($generalSetting as $item)
                                    <input type="hidden" name="general_id" id="general_id" value="{{$item->id}}"> 
                                    <div class="form-group m-form__group row @if ($errors->has('currency')) has-danger @endif">
                                        {!!Form::label('currency','Currency',['class' => 'col-sm-3 col-form-label'])!!}
                                            <div class="col-sm-5">
                                                <select class="form-control m-input" name="currency" id="currency">
                                                    @foreach ($getCurrentCode as $key=>$value)
                                                        @if($item->currency == null)
                                                            @if ($key == 'USD')
                                                                <option class="form-control m-input" selected value="{{$key}}">{{$value['name'] .'-'. $value['symbol']}}</option>
                                                            @else
                                                                <option class="form-control m-input" value="{{$key}}">{{$value['name'] .'-'. $value['symbol']}}</option>
                                                            @endif
                                                        @else
                                                            @if ($key == $item->currency)
                                                                <option class="form-control m-input" selected value="{{$key}}">{{$value['name'] .' - '. $value['symbol']}}</option>
                                                            @else
                                                                <option class="form-control m-input" value="{{$key}}">{{$value['name'] .'-'. $value['symbol']}}</option>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                </select> @if ($errors->has('currency'))
                                                <p class="form-control-feedback">{{ $errors->first('currency') }}</p> @endif
                                            </div>
                                    </div>
                                    <div class="form-group m-form__group row @if ($errors->has('timezone')) has-danger @endif">
                                        {!!Form::label('timezone','Timezone',['class' => 'col-sm-3 col-form-label'])!!}
                                            <div class="col-sm-5">
                                                <select class="form-control m-input" name="timezone" id="timezone">
                                                    @foreach ($timezones as $key=>$value)
                                                        @if (empty($key))
                                                            @if($key == 'Asia/Phnom_Penh')
                                                                <option class="form-control m-input" selected value="{{$key}}">{{$value}}</option>
                                                            @else
                                                                <option class="form-control m-input" value="{{$key}}">{{$value}}</option>
                                                            @endif
                                                        @else
                                                            @if($key == $item->timezone)
                                                                <option class="form-control m-input" selected value="{{$key}}">{{$value}}</option>
                                                            @else
                                                                <option class="form-control m-input" value="{{$key}}">{{$value}}</option>
                                                            @endif
                                                        @endif
                                                        
                                                    @endforeach
                                                </select> 
                                                @if ($errors->has('timezone'))
                                                <p class="form-control-feedback">{{ $errors->first('timezone') }}</p> @endif
                                            </div>
                                    </div>
                                    
                                    <div class="form-group m-form__group row @if($errors->has('logo')) has-danger @endif">
                                        {!!Form::label('logo','Logo',['class' => 'col-sm-3 col-form-label'])!!}
                                            <div class="col-sm-5">
                                                {!!Form::file('logo',['id' =>'logo'])!!} @if ($errors->has('logo'))
                                                <p class="form-control-feedback">{{ $errors->first('logo') }}</p> @endif
                                            </div>
                                    </div>
                                    <div class="form-group m-form__group row @if($errors->has('icon')) has-danger @endif">
                                        {!!Form::label('icon','Favicon',['class' => 'col-sm-3 col-form-label'])!!}
                                            <div class="col-sm-5">
                                                {!!Form::file('icon',['id' =>'icon'])!!} @if ($errors->has('icon'))
                                                <p class="form-control-feedback">{{ $errors->first('icon') }}</p> @endif
                                            </div>
                                    </div>
                                        @push('javascript')
                                            <script type="text/javascript">
                                                jQuery(document).ready(function() {
                                                    $('#icon').ace_file_input('show_file_list', [{
                                                        type: 'image',
                                                        name: '{{asset($item->icon)}}'
                                                    }]);
                                                    $('#logo').ace_file_input('show_file_list', [{
                                                        type: 'image',
                                                        name: '{{asset($item->logo)}}'
                                                    }]);
                                                })
                                            </script>
                                        @endpush
                                        <div class="form-group m-form__group row">
                                                <div class="col-sm-3"></div>
                                                <div class="col-sm-9">
                                                    <button type="submit" name="btnsavecloseGeneral" id="btnsavecloseGeneral" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                                            <span>
                                                                <i class="fa fa-archive"></i>
                                                                <span>{{__('trans.btnsave')}}</span>
                                                            </span>
                                                        </button>
                                                </div>
                                            </div>
                                @endforeach 
                                {!!Form::close()!!}
                            @else
                            {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/generalsettings/0'), 'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method'=> 'PATCH'])!!} 
                                <div class="form-group m-form__group row @if ($errors->has('currency')) has-danger @endif">
                                    {!!Form::label('currency','Currency',['class' => 'col-sm-3 col-form-label'])!!}
                                    <div class="col-sm-5">
                                        <select class="form-control m-input" name="currency" id="currency">
                                                                        @foreach ($getCurrentCode as $key=>$value)
                                                                            @if ($key == 'USD')
                                                                                <option class="form-control m-input" selected value="{{$key}}">{{$value['name'] .' - '. $value['symbol']}}</option>
                                                                            @else
                                                                                <option class="form-control m-input" value="{{$key}}">{{$value['name'] .'-'. $value['symbol']}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select> @if ($errors->has('currency'))
                                        <p class="form-control-feedback">{{ $errors->first('currency') }}</p> @endif
                                    </div>
                                </div>
                                <div class="form-group m-form__group row @if ($errors->has('timezone')) has-danger @endif">
                                    {!!Form::label('timezone','Timezone',['class' => 'col-sm-3 col-form-label'])!!}
                                    <div class="col-sm-5">
                                        <select class="form-control m-input" name="timezone" id="timezone">
                                                    @foreach ($timezones as $key=>$value)
                                                            @if($key == 'Asia/Phnom_Penh')
                                                                <option class="form-control m-input" selected value="{{$key}}">{{$value}}</option>
                                                            @else
                                                                <option class="form-control m-input" value="{{$key}}">{{$value}}</option>
                                                            @endif
                                                    @endforeach
                                                </select> @if ($errors->has('timezone'))
                                        <p class="form-control-feedback">{{ $errors->first('timezone') }}</p> @endif
                                    </div>
                                </div>
                                <div class="form-group m-form__group row @if($errors->has('logo')) has-danger @endif">
                                    {!!Form::label('logo','Logo',['class' => 'col-sm-3 col-form-label'])!!}
                                    <div class="col-sm-5">

                                        {!!Form::file('logo',['id' =>'logo'])!!} @if ($errors->has('logo'))
                                        <p class="form-control-feedback">{{ $errors->first('logo') }}</p> @endif
                                    </div>
                                </div>
                                <div class="form-group m-form__group row @if($errors->has('icon')) has-danger @endif">
                                    {!!Form::label('icon','Favicon',['class' => 'col-sm-3 col-form-label'])!!}
                                    <div class="col-sm-5">

                                        {!!Form::file('icon',['id' =>'icon'])!!} @if ($errors->has('icon'))
                                        <p class="form-control-feedback">{{ $errors->first('icon') }}</p> @endif
                                    </div>
                                </div>
                                <div class="form-group m-form__group row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9">
                                            <button type="submit" name="btnsavecloseGeneral" id="btnsavecloseGeneral" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                                    <span>
                                                        <i class="fa fa-archive"></i>
                                                        <span>{{__('trans.btnsave')}}</span>
                                                    </span>
                                                </button>
                                        </div>
                                    </div>
                                    {!!Form::close()!!}
                                    @endif 
                </div>



                <div class="tab-pane" id="m_portlet_base_demo_2_2_tab_content" role="tabpanel">
                    @if (!$mailConfig->isEmpty()) 
                        @foreach ($mailConfig as $item)
                            {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/generalsettings/0'),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form1','files'=>true,'method'=> 'PATCH'])!!}
                                <input type="hidden" id="mailConfig_id" name="mailConfig_id" value="{{$item->id}}">
                                <div class="form-group m-form__group row @if ($errors->has('mailFromName')) has-danger @endif">
                                    {!!Form::label('mailFromName','Mail From Name',['class' => 'col-sm-3 col-form-label required'])!!}
                                    <div class="col-sm-7">
                                        {!!Form::text('mailFromName',old('mailFromName',$item->mail_name),['class' => 'form-control m-input','placeholder' => 'Example','id'=>'mailFromName'])!!}
                                        <p><i>This Will be display name for your sent email.</i></p>
                                        @if ($errors->has('mailFromName'))<p class="form-control-feedback">{{ $errors->first('mailFromName') }}</p> @endif
                                    </div>
                                </div>
                                <div class="form-group m-form__group row @if ($errors->has('mailFromAddress')) has-danger @endif">
                                    {!!Form::label('mailFromAddress','Mail From Address',['class' => 'col-sm-3 col-form-label required'])!!}
                                    <div class="col-sm-7">
                                        {!!Form::text('mailFromAddress',old('mailFromAddress', $item->mail_address),['class' => 'form-control m-input','placeholder' => 'hello@example.com','id'=>'mailFromAddress'])!!}
                                        <p><i>This Email will be used for "Contact Form" correspondence.</i></p>
                                        @if ($errors->has('mailFromAddress'))<p class="form-control-feedback">{{ $errors->first('mailFromAddress') }}</p> @endif
                                    </div>
                                </div>
                                <div class="form-group m-form__group row @if ($errors->has('smtp')) has-danger @endif">
                                    {!!Form::label('smtp','Mail Driver',['class' => 'col-sm-3 col-form-label required'])!!}
                                    <div class="col-sm-7">
                                        {!!Form::text('smtp',old('smtp', $item->mail_smtp),['class' => 'form-control m-input','placeholder' => 'smtp','id'=>'smtp'])!!}
                                        <p class="mb-0"><i>You can select any driver you want for your Mail setup. <strong>Ex. SMTP, Mailgun, Mandrill, SparkPost, Amazon SES etx.</strong></i></p>
                                        <p><i>Add <strong>single driver only.</strong></i></p>
                                        @if ($errors->has('smtp'))<p class="form-control-feedback">{{ $errors->first('smtp') }}</p> @endif
                                    </div>
                                </div>
                                <div class="form-group m-form__group row @if ($errors->has('mailHost')) has-danger @endif">
                                    {!!Form::label('mailHost','Mail HOST',['class' => 'col-sm-3 col-form-label required'])!!}
                                    <div class="col-sm-7">
                                        {!!Form::text('mailHost',old('mailHost', $item->mail_host),['class' => 'form-control m-input','placeholder' => 'smtp.mailtrap.io','id'=>'mailHost'])!!}
                                        @if ($errors->has('mailHost'))<p class="form-control-feedback">{{ $errors->first('mailHost') }}</p> @endif
                                    </div>
                                </div>
                                <div class="form-group m-form__group row @if ($errors->has('mailPort')) has-danger @endif">
                                    {!!Form::label('mailPort','Mail PORT',['class' => 'col-sm-3 col-form-label required'])!!}
                                    <div class="col-sm-7">
                                        {!!Form::text('mailPort',old('mailPort', $item->mail_port),['class' => 'form-control m-input','placeholder' => '2525','id'=>'mailPort'])!!}
                                        @if ($errors->has('mailPort'))<p class="form-control-feedback">{{ $errors->first('mailPort') }}</p> @endif
                                    </div>
                                </div>
                                <div class="form-group m-form__group row @if ($errors->has('mailUserName')) has-danger @endif">
                                    {!!Form::label('mailUserName','Mail Username',['class' => 'col-sm-3 col-form-label required'])!!}
                                    <div class="col-sm-7">
                                        {!!Form::text('mailUserName',old('mailUserName',$item->mail_username),['class' => 'form-control m-input','placeholder' => 'Ex, myemaill@email.com','id'=>'mailUserName'])!!}
                                        <p><i>Add your email id you want to configure for sending emails.</i></p>
                                        @if ($errors->has('mailUserName'))<p class="form-control-feedback">{{ $errors->first('mailUserName') }}</p> @endif
                                    </div>
                                </div>
                                <div class="form-group m-form__group row @if ($errors->has('mailPassword')) has-danger @endif">
                                    {!!Form::label('mailPassword','Mail Password',['class' => 'col-sm-3 col-form-label required'])!!}
                                    <div class="col-sm-7">
                                        {!!Form::text('mailPassword',old('mailPassword', $item->mail_password),['class' => 'form-control m-input','placeholder' => 'Ex, myemaill@email.com','id'=>'mailPassword'])!!}
                                        <p><i>Add your eamil password you want to configure for sending emails</i></p>
                                        @if ($errors->has('mailPassword'))<p class="form-control-feedback">{{ $errors->first('mailPassword') }}</p> @endif
                                    </div>
                                </div>
                                <div class="form-group m-form__group row @if ($errors->has('mailEncryption')) has-danger @endif">
                                    {!!Form::label('mailEncryption','Mail Encryption',['class' => 'col-sm-3 col-form-label'])!!}
                                    <div class="col-sm-7">
                                        {!!Form::text('mailEncryption',old('mailEncryption', $item->mail_encryption),['class' => 'form-control m-input','placeholder' => 'tls Or ssl','id'=>'mailEncryption'])!!}
                                        <p><i>Use <strong>tls</strong> if your site uses <strong>HTTP</strong> protocol and <strong>ssl </strong>if you site uses <strong>HTTPS</strong> Protocol</i></p>
                                        {{--  {!!Form::select('isparent',$item,old('isparent',$item->mail_encryption),['class'=>'form-control m-input'])!!}  --}}
                                        @if ($errors->has('mailEncryption'))
                                        <p class="form-control-feedback">{{ $errors->first('mailEncryption') }}</p> @endif
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group m-form__group row @if ($errors->has('mailEncryption')) has-danger @endif">
                                        <div class="col-sm-2"></div>
                                        <div class="col-sm-9">
                                            <p>
                                                <strong>Important Note :</strong> IF you are using <strong>GMAIl</strong> for Mail configuration, make sure you have completed following process before updating:
                                                <li>Go to <a href="https://myaccount.google.com/security">My Account</a> from your Google Account you want to configure and Login</li>
                                                <li>Scroll down to <strong>Less secure app access </strong> and set it <strong>ON</strong></li>
                                            </p>
                                        </div>
                                    </div>
                                <div class="form-group m-form__group row">
                                    <div class="col-sm-3"></div>
                                    <div class="col-sm-9">
                                        <button type="submit" name="btnsavecloseMailConfig" id="btnsavecloseMailConfig" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                                <span>
                                                    <i class="fa fa-archive"></i>
                                                    <span>{{__('trans.btnsave')}}</span>
                                                </span>
                                            </button>
                                    </div>
                                </div>
                            {!!Form::close()!!}
                        @endforeach
                    @else
                        {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/generalsettings/0'),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form1','files'=>true,'method'=> 'PATCH'])!!}
                            <div class="form-group m-form__group row @if ($errors->has('mailFromName')) has-danger @endif">
                                {!!Form::label('mailFromName','Mail From Name',['class' => 'col-sm-3 col-form-label required'])!!}
                                <div class="col-sm-7">
                                    {!!Form::text('mailFromName',old('mailFromName'),['class' => 'form-control m-input','placeholder' => 'Example','id'=>'mailFromName'])!!}
                                    <p><i>This Will be display name for your sent email.</i></p>
                                    @if ($errors->has('mailFromName'))<p class="form-control-feedback">{{ $errors->first('mailFromName') }}</p> @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('mailFromAddress')) has-danger @endif">
                                {!!Form::label('mailFromAddress','Mail From Address',['class' => 'col-sm-3 col-form-label required'])!!}
                                <div class="col-sm-7">
                                    {!!Form::text('mailFromAddress',old('mailFromAddress'),['class' => 'form-control m-input','placeholder' => 'hello@example.com','id'=>'mailFromAddress'])!!}
                                    <p><i>This Email will be used for "Contact Form" correspondence.</i></p>
                                    @if ($errors->has('mailFromAddress'))<p class="form-control-feedback">{{ $errors->first('mailFromAddress') }}</p> @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('smtp')) has-danger @endif">
                                {!!Form::label('smtp','Mail Driver',['class' => 'col-sm-3 col-form-label required'])!!}
                                <div class="col-sm-7">
                                    {!!Form::text('smtp',old('smtp'),['class' => 'form-control m-input','placeholder' => 'smtp','id'=>'smtp'])!!}
                                    <p class="mb-0"><i>You can select any driver you want for your Mail setup. <strong>Ex. SMTP, Mailgun, Mandrill, SparkPost, Amazon SES etx.</strong></i></p>
                                    <p><i>Add <strong>single driver only.</strong></i></p>
                                    @if ($errors->has('smtp'))<p class="form-control-feedback">{{ $errors->first('smtp') }}</p> @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('mailHost')) has-danger @endif">
                                {!!Form::label('mailHost','Mail HOST',['class' => 'col-sm-3 col-form-label required'])!!}
                                <div class="col-sm-7">
                                    {!!Form::text('mailHost',old('mailHost'),['class' => 'form-control m-input','placeholder' => 'smtp.mailtrap.io','id'=>'mailHost'])!!}
                                    @if ($errors->has('mailHost'))<p class="form-control-feedback">{{ $errors->first('mailHost') }}</p> @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('mailPort')) has-danger @endif">
                                {!!Form::label('mailPort','Mail PORT',['class' => 'col-sm-3 col-form-label required'])!!}
                                <div class="col-sm-7">
                                    {!!Form::text('mailPort',old('mailPort'),['class' => 'form-control m-input','placeholder' => '2525','id'=>'mailPort'])!!}
                                    @if ($errors->has('mailPort'))<p class="form-control-feedback">{{ $errors->first('mailPort') }}</p> @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('mailUserName')) has-danger @endif">
                                {!!Form::label('mailUserName','Mail Username',['class' => 'col-sm-3 col-form-label required'])!!}
                                <div class="col-sm-7">
                                    {!!Form::text('mailUserName',old('mailUserName'),['class' => 'form-control m-input','placeholder' => 'Ex, myemaill@email.com','id'=>'mailUserName'])!!}
                                    <p><i>Add your email id you want to configure for sending emails.</i></p>
                                    @if ($errors->has('mailUserName'))<p class="form-control-feedback">{{ $errors->first('mailUserName') }}</p> @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('mailPassword')) has-danger @endif">
                                {!!Form::label('mailPassword','Mail Password',['class' => 'col-sm-3 col-form-label required'])!!}
                                <div class="col-sm-7">
                                    {!!Form::text('mailPassword',old('mailPassword'),['class' => 'form-control m-input','placeholder' => 'Ex, myemaill@email.com','id'=>'mailPassword'])!!}
                                    <p><i>Add your eamil password you want to configure for sending emails</i></p>
                                    @if ($errors->has('mailPassword'))<p class="form-control-feedback">{{ $errors->first('mailPassword') }}</p> @endif
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('mailEncryption')) has-danger @endif">
                                {!!Form::label('mailEncryption','Mail Encryption',['class' => 'col-sm-3 col-form-label'])!!}
                                <div class="col-sm-7">
                                    {!!Form::text('mailEncryption',old('mailEncryption'),['class' => 'form-control m-input','placeholder' => 'Ex, myemaill@email.com','id'=>'mailEncryption'])!!}
                                    <p><i>Use <strong>tls</strong> if your site uses <strong>HTTP</strong> protocol and <strong>ssl </strong>if you site uses <strong>HTTPS</strong> Protocol</i></p>
                                    @if ($errors->has('mailEncryption'))
                                    <p class="form-control-feedback">{{ $errors->first('mailEncryption') }}</p> @endif
                                </div>
                            </div>
                            <hr>
                                <div class="form-group m-form__group row @if ($errors->has('mailEncryption')) has-danger @endif">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-9">
                                        <p>
                                            <strong>Important Note :</strong> IF you are using <strong>GMAIl</strong> for Mail configuration, make sure you have completed following process before updating:
                                            <li>Go to <a href="https://myaccount.google.com/security">My Account</a> from your Google Account you want to configure and Login</li>
                                            <li>Scroll down to <strong>Less secure app access </strong> and set it <strong>ON</strong></li>
                                        </p>
                                    </div>
                                </div>
                            <div class="form-group m-form__group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <button type="submit" name="btnsavecloseMailConfig" id="btnsavecloseMailConfig" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                            <span>
                                                <i class="fa fa-archive"></i>
                                                <span>{{__('trans.btnsave')}}</span>
                                            </span>
                                        </button>
                                </div>
                            </div>
                        {!!Form::close()!!}
                    @endif
                    
                    
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
</style>
@endpush @push('javascript') {{--


<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>--}}

<script type="text/javascript" src="{{ asset('backend/assets/jquery.furl.js')}}"></script>
<script type="text/javascript" charset="utf8" src="{{asset('backend/assets/tagsinput/tagsinput.js')}}"></script>
{{--{!!JsValidator::formRequest('App\Http\Requests\CategoriesRequest', '#idev-form')!!}--}} 
@include('backend.shared._selectimg',['selectElement' => '#logo,#icon']) 
@include('backend.shared._tinymce',['elements' => '.cms-editor'])
<script type="text/javascript">
    var BootstrapSwitch = {
        init: function() {
            $("[data-switch=true]").bootstrapSwitch()
        }
    };

    jQuery(document).ready(function() {
        BootstrapSwitch.init()
    });
    /*
    $('#idev-form').on('submit', function() {
   
       // var test = $("#idev-form").serialize();

        $.ajax({
            url: '{{ url(_ADMIN_PREFIX_URL."/generalsettings/0") }}',
            method: 'PATCH',
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                currency,
                id,
                logo,
                icon
            },

            data:  new FormData(this),
            success: function(res) {
                swal({
                    title: res.title,
                    html: res.message,
                    type: res.status,
                    allowOutsideClick: false,
                    timer: 1500
                });
            }
        })
    })
    */
</script>
@endpush