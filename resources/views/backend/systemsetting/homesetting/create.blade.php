@extends('backend.template.main') @push('title',trans('menu.setting').'-'.trans('trans.create')) @section('content') {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/homesettings/0'),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method'
=> 'PATCH'])!!}
<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

    <div class="m-portlet__head" style="">
        <div class="m-portlet__head-wrapper">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{trans('menu.setting').' / '.trans('trans.create')}}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                @include('backend.shared._actionform')
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
      @php($getCurrentCode =Config('sysconfig.currency_code') ) 
          {{-- {{dd($getCurrentCode)}} --}}
        @if(!$record->isEmpty())
        @foreach($record as $item)
        <input type="hidden" value="{!!$item->id!!}" name="id">
        <div class="form-group m-form__group row @if ($errors->has('name')) has-danger @endif">
            {!!Form::label('name','Name',['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('name',old('name',$item->sc_name),['class' => 'form-control m-input','id'=>'name'])!!} @if ($errors->has('name'))
                    <p class="form-control-feedback">{{ $errors->first('name') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('address')) has-danger @endif">
            {!!Form::label('address','Address',['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('address',old('address',$item->sc_address),['class' => 'form-control m-input','id'=>'address'])!!} @if ($errors->has('address'))
                    <p class="form-control-feedback">{{ $errors->first('address') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('phone')) has-danger @endif">
            {!!Form::label('phone','Phone',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('phone',old('phone',$item->sc_phone),['class' => 'form-control m-input','id'=>'phone'])!!} @if ($errors->has('phone'))
                    <p class="form-control-feedback">{{ $errors->first('phone') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('sms')) has-danger @endif">
            {!!Form::label('sms','SMS',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('sms',old('sms',$item->sc_sms),['class' => 'form-control m-input','id'=>'sms'])!!} @if ($errors->has('sms'))
                    <p class="form-control-feedback">{{ $errors->first('sms') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('pinbb')) has-danger @endif">
            {!!Form::label('pinbb','Pin BB',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('pinbb',old('pinbb',$item->sc_pinbb),['class' => 'form-control m-input','id'=>'pinbb'])!!} @if ($errors->has('pinbb'))
                    <p class="form-control-feedback">{{ $errors->first('pinbb') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('wechat')) has-danger @endif">
            {!!Form::label('wechat','WeChat',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('wechat',old('wechat',$item->sc_wechat),['class' => 'form-control m-input','id'=>'wechat'])!!} @if ($errors->has('wechat'))
                    <p class="form-control-feedback">{{ $errors->first('wechat') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('line')) has-danger @endif">
            {!!Form::label('line','Line',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('line',old('line',$item->sc_line),['class' => 'form-control m-input','id'=>'line'])!!} @if ($errors->has('line'))
                    <p class="form-control-feedback">{{ $errors->first('line') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('facebook')) has-danger @endif">
            {!!Form::label('facebook','Facebook',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('facebook',old('facebook',$item->sc_facebook),['class' => 'form-control m-input','id'=>'facebook'])!!} @if ($errors->has('facebook'))
                    <p class="form-control-feedback">{{ $errors->first('facebook') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('twitter')) has-danger @endif">
            {!!Form::label('twitter','Twitter',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('twitter',old('twitter',$item->sc_twitter),['class' => 'form-control m-input','id'=>'twitter'])!!} @if ($errors->has('twitter'))
                    <p class="form-control-feedback">{{ $errors->first('twitter') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('google')) has-danger @endif">
            {!!Form::label('google','Google',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('google',old('google',$item->sc_google),['class' => 'form-control m-input','id'=>'google'])!!} @if ($errors->has('google'))
                    <p class="form-control-feedback">{{ $errors->first('google') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('mail')) has-danger @endif">
            {!!Form::label('mail','Mail',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('mail',old('mail',$item->sc_email),['class' => 'form-control m-input','id'=>'mail'])!!} @if ($errors->has('mail'))
                    <p class="form-control-feedback">{{ $errors->first('mail') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('title')) has-danger @endif">
            {!!Form::label('title','Title',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::textarea('title',old('title',$item->sc_title),['class' => 'form-control m-input','rows'=>'5','id'=>'title'])!!} @if ($errors->has('title'))
                    <p class="form-control-feedback">{{ $errors->first('title') }}</p> @endif
                </div>
            </div>
        </div>

        <div class="form-group m-form__group row @if ($errors->has('keywords')) has-danger @endif">
            {!!Form::label('keywords','Keywords',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::textarea('keywords',old('keywords',$item->sc_keywords),['class' => 'form-control m-input','rows'=>'5','id'=>'keywords'])!!} @if ($errors->has('keywords'))
                    <p class="form-control-feedback">{{ $errors->first('keywords') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('description')) has-danger @endif">
            {!!Form::label('description','Description',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::textarea('description',old('description',$item->sc_description),['class' => 'form-control m-input','rows'=>'5','id'=>'description'])!!} @if ($errors->has('description'))
                    <p class="form-control-feedback">{{ $errors->first('description') }}</p> @endif
                </div>
            </div>
        </div>
        
        <div class="form-group m-form__group row @if ($errors->has('market')) has-danger @endif">
            {!!Form::label('market','Market',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <select class="form-control m-input" name="market" id="market_id">
                    @foreach ($getCurrentCode as $key=>$value)
                        <option class="form-control m-input" value="{{$key}}">{{$value['name']}}</option>
                    @endforeach
                </select> @if ($errors->has('market'))
                            <p class="form-control-feedback">{{ $errors->first('market') }}</p> @endif
            </div>
        </div>
        {{-- <div class="form-group m-form__group row @if ($errors->has('ipfilter_alias_exception')) has-danger @endif">
            {!!Form::label('ipfilter_alias_exception','Exception Keyword ',['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('ipfilter_alias_exception',old('ipfilter_alias_exception',$item->sc_ipfilter_alias_exception),['class' => 'form-control m-input','id'=>'ipfilter_alias_exception'])!!} @if ($errors->has('ipfilter_alias_exception'))
                    <p class="form-control-feedback">{{ $errors->first('ipfilter_alias_exception') }}</p> @endif
                </div>
            </div>
        </div> --}}
       @endforeach
        @else
        <div class="form-group m-form__group row @if ($errors->has('name')) has-danger @endif">
            {!!Form::label('name','Name',['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('name',old('name'),['class' => 'form-control m-input','id'=>'name', 'placeholder' => 'Please Input Name'])!!} @if ($errors->has('name'))
                    <p class="form-control-feedback">{{ $errors->first('name') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('address')) has-danger @endif">
            {!!Form::label('address','Address',['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('address',old('address'),['class' => 'form-control m-input','id'=>'address','placeholder' => 'Please Input Address'])!!} @if ($errors->has('address'))
                    <p class="form-control-feedback">{{ $errors->first('address') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('phone')) has-danger @endif">
            {!!Form::label('phone','Phone',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('phone',old('phone'),['class' => 'form-control m-input','id'=>'phone','placeholder' => 'Please Input Phone'])!!} @if ($errors->has('phone'))
                    <p class="form-control-feedback">{{ $errors->first('phone') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('sms')) has-danger @endif">
            {!!Form::label('sms','SMS',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('sms',old('sms'),['class' => 'form-control m-input','id'=>'sms','placeholder' => 'Please Input SMS'])!!} @if ($errors->has('sms'))
                    <p class="form-control-feedback">{{ $errors->first('sms') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('pinbb')) has-danger @endif">
            {!!Form::label('pinbb','Pin BB',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('pinbb',old('pinbb'),['class' => 'form-control m-input','id'=>'pinbb','placeholder' => 'Please Input Pin BB'])!!} @if ($errors->has('pinbb'))
                    <p class="form-control-feedback">{{ $errors->first('pinbb') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('wechat')) has-danger @endif">
            {!!Form::label('wechat','WeChat',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('wechat',old('wechat'),['class' => 'form-control m-input','id'=>'wechat','placeholder' => 'Please Input Wechat'])!!} @if ($errors->has('wechat'))
                    <p class="form-control-feedback">{{ $errors->first('wechat') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('line')) has-danger @endif">
            {!!Form::label('line','Line',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('line',old('line'),['class' => 'form-control m-input','id'=>'line','placeholder' => 'Please Input Line'])!!} @if ($errors->has('line'))
                    <p class="form-control-feedback">{{ $errors->first('line') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('facebook')) has-danger @endif">
            {!!Form::label('facebook','Facebook',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('facebook',old('facebook'),['class' => 'form-control m-input','id'=>'facebook','placeholder' => 'Please Input Facebook'])!!} @if ($errors->has('facebook'))
                    <p class="form-control-feedback">{{ $errors->first('facebook') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('twitter')) has-danger @endif">
            {!!Form::label('twitter','Twitter',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('twitter',old('twitter'),['class' => 'form-control m-input','id'=>'twitter','placeholder' => 'Please Input Twitter'])!!} @if ($errors->has('twitter'))
                    <p class="form-control-feedback">{{ $errors->first('twitter') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('google')) has-danger @endif">
            {!!Form::label('google','Google',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('google',old('google'),['class' => 'form-control m-input','id'=>'google','placeholder' => 'Please Input Google'])!!} @if ($errors->has('google'))
                    <p class="form-control-feedback">{{ $errors->first('google') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('mail')) has-danger @endif">
            {!!Form::label('mail','Mail',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('mail',old('mail'),['class' => 'form-control m-input','id'=>'mail','placeholder' => 'Please Input Mail'])!!} @if ($errors->has('mail'))
                    <p class="form-control-feedback">{{ $errors->first('mail') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('title')) has-danger @endif">
            {!!Form::label('title','Title',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::textarea('title',old('title'),['class' => 'form-control m-input','rows'=>'5','id'=>'title','placeholder' => 'Please Input Title'])!!} @if ($errors->has('title'))
                    <p class="form-control-feedback">{{ $errors->first('title') }}</p> @endif
                </div>
            </div>
        </div>

        <div class="form-group m-form__group row @if ($errors->has('keywords')) has-danger @endif">
            {!!Form::label('keywords','Keywords',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::textarea('keywords',old('keywords'),['class' => 'form-control m-input','rows'=>'5','id'=>'keywords','placeholder' => 'Please Input Keywords'])!!} @if ($errors->has('keywords'))
                    <p class="form-control-feedback">{{ $errors->first('keywords') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('description')) has-danger @endif">
            {!!Form::label('description','Description',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::textarea('description',old('description'),['class' => 'form-control m-input','rows'=>'5','id'=>'description','placeholder' => 'Please Input Description'])!!} @if ($errors->has('description'))
                    <p class="form-control-feedback">{{ $errors->first('description') }}</p> @endif
                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('ipfilter_alias_exception')) has-danger @endif">
            {!!Form::label('ipfilter_alias_exception','Exception Keyword ',['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-7">
                <div class="input-group">
                    {!!Form::text('ipfilter_alias_exception',old('ipfilter_alias_exception'),['class' => 'form-control m-input','id'=>'ipfilter_alias_exception','placeholder' => 'Please Input Exception Keyword'])!!} @if ($errors->has('ipfilter_alias_exception'))
                    <p class="form-control-feedback">{{ $errors->first('ipfilter_alias_exception') }}</p> @endif
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
{!!Form::close()!!}
@endsection 
@push('style')
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
{{--{!!JsValidator::formRequest('App\Http\Requests\CategoriesRequest', '#idev-form')!!}--}} @include('backend.shared._selectimg',['selectElement' => '#banner']) @include('backend.shared._tinymce',['elements' => '.cms-editor'])
<script type="text/javascript">
    var BootstrapSwitch = {
        init: function() {
            $("[data-switch=true]").bootstrapSwitch()
        }
    };
    jQuery(document).ready(function() {
        BootstrapSwitch.init();
    });
</script>
@endpush