@extends('backend.template.main') @push('title',trans('menu.setting').'-'.trans('trans.create')) @section('content') {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/homesettings/0'),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method'
=> 'PATCH'])!!}
<!--   -->
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
                {{-- @include('backend.shared._actionform') --}}
                <div class="m-demo__preview m-demo__preview--btn">
                    <button type="submit" name="btnsaveclose" id="btnsaveclose" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                            <span>
                                <i class="fa fa-archive"></i>
                                <span>{{__('trans.btnsave')}}</span>
                            </span>
                        </button>

                </div>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        @php($getCurrentCode =Config('sysconfig.currency_code') ) {{-- {{dd($getCurrentCode)}} --}}
        <input type="hidden" value="{!!$record->id!!}" name="id" id="id">

        <div class="form-group m-form__group row @if ($errors->has('name')) has-danger @endif">
            {!!Form::label('name', trans('labels.name'),['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-7">
                {!!Form::text('name',old('name',$record->sc_name),['class' => 'form-control m-input','id'=>'name'])!!} @if ($errors->has('name'))
                <p class="form-control-feedback">{{ $errors->first('name') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('address')) has-danger @endif">
            {!!Form::label('address', trans('labels.address'),['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-7">
                {!!Form::text('address',old('address',$record->sc_address),['class' => 'form-control m-input','id'=>'address'])!!} @if ($errors->has('address'))
                <p class="form-control-feedback">{{ $errors->first('address') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('phone')) has-danger @endif">
            {!!Form::label('phone',trans('labels.phone'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">

                {!!Form::text('phone',old('phone',$record->sc_phone),['class' => 'form-control m-input','id'=>'phone'])!!} @if ($errors->has('phone'))
                <p class="form-control-feedback">{{ $errors->first('phone') }}</p> @endif

            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('sms')) has-danger @endif">
            {!!Form::label('sms', trans('labels.sms'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">

                {!!Form::text('sms',old('sms',$record->sc_sms),['class' => 'form-control m-input','id'=>'sms'])!!} @if ($errors->has('sms'))
                <p class="form-control-feedback">{{ $errors->first('sms') }}</p> @endif

            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('pinbb')) has-danger @endif">
            {!!Form::label('pinbb', trans('labels.pinbb'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">

                {!!Form::text('pinbb',old('pinbb',$record->sc_pinbb),['class' => 'form-control m-input','id'=>'pinbb'])!!} @if ($errors->has('pinbb'))
                <p class="form-control-feedback">{{ $errors->first('pinbb') }}</p> @endif

            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('wechat')) has-danger @endif">
            {!!Form::label('wechat', trans('labels.wechat'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">

                {!!Form::text('wechat',old('wechat',$record->sc_wechat),['class' => 'form-control m-input','id'=>'wechat'])!!} @if ($errors->has('wechat'))
                <p class="form-control-feedback">{{ $errors->first('wechat') }}</p> @endif

            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('line')) has-danger @endif">
            {!!Form::label('line', trans('labels.line'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">

                {!!Form::text('line',old('line',$record->sc_line),['class' => 'form-control m-input','id'=>'line'])!!} @if ($errors->has('line'))
                <p class="form-control-feedback">{{ $errors->first('line') }}</p> @endif

            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('facebook')) has-danger @endif">
            {!!Form::label('facebook', trans('labels.facebook'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">

                {!!Form::text('facebook',old('facebook',$record->sc_facebook),['class' => 'form-control m-input','id'=>'facebook'])!!} @if ($errors->has('facebook'))
                <p class="form-control-feedback">{{ $errors->first('facebook') }}</p> @endif

            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('twitter')) has-danger @endif">
            {!!Form::label('twitter', trans('labels.twitter'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">

                {!!Form::text('twitter',old('twitter',$record->sc_twitter),['class' => 'form-control m-input','id'=>'twitter'])!!} @if ($errors->has('twitter'))
                <p class="form-control-feedback">{{ $errors->first('twitter') }}</p> @endif

            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('google')) has-danger @endif">
            {!!Form::label('google', trans('labels.google'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">

                {!!Form::text('google',old('google',$record->sc_google),['class' => 'form-control m-input','id'=>'google'])!!} @if ($errors->has('google'))
                <p class="form-control-feedback">{{ $errors->first('google') }}</p> @endif

            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('mail')) has-danger @endif">
            {!!Form::label('mail', trans('labels.mail'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">

                {!!Form::text('mail',old('mail',$record->sc_email),['class' => 'form-control m-input','id'=>'mail'])!!} @if ($errors->has('mail'))
                <p class="form-control-feedback">{{ $errors->first('mail') }}</p> @endif

            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('title')) has-danger @endif">
            {!!Form::label('title', trans('labels.title'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">

                {!!Form::textarea('title',old('title',$record->sc_title),['class' => 'form-control m-input','rows'=>'5','id'=>'title'])!!} @if ($errors->has('title'))
                <p class="form-control-feedback">{{ $errors->first('title') }}</p> @endif

            </div>
        </div>

        <div class="form-group m-form__group row @if ($errors->has('keywords')) has-danger @endif">
            {!!Form::label('keywords', trans('labels.keywords'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">

                {!!Form::textarea('keywords',old('keywords',$record->sc_keywords),['class' => 'form-control m-input','rows'=>'5','id'=>'keywords'])!!} @if ($errors->has('keywords'))
                <p class="form-control-feedback">{{ $errors->first('keywords') }}</p> @endif

            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('description')) has-danger @endif">
            {!!Form::label('description', trans('labels.description'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">

                {!!Form::textarea('description',old('description',$record->sc_description),['class' => 'form-control m-input','rows'=>'5','id'=>'description'])!!} @if ($errors->has('description'))
                <p class="form-control-feedback">{{ $errors->first('description') }}</p> @endif

            </div>
        </div>

        <div class="form-group m-form__group row @if ($errors->has('currency')) has-danger @endif d-none">
            {!!Form::label('currency', trans('labels.currency'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <select class="form-control m-input" name="currency" id="currency">
                    @foreach ($getCurrentCode as $key=>$value)
                        @if($record->currency == null)
                            @if ($key == 'USD')
                                <option class="form-control m-input" selected value="{{$key}}">{{$value['name'] .'-'. $value['symbol']}}</option>
                            @else
                                <option class="form-control m-input" value="{{$key}}">{{$value['name'] .'-'. $value['symbol']}}</option>
                            @endif
                        @else
                            @if ($key == $record->currency)
                                <option class="form-control m-input" selected value="{{$key}}">{{$value['name'] .' - '. $value['symbol']}}</option>
                            @else
                                <option class="form-control m-input" value="{{$key}}">{{$value['name'] .'-'. $value['symbol']}}</option>
                            @endif
                        @endif
                        {{-- @if ($key == $record->currency)
                            <option class="form-control m-input" selected value="{{$key}}">{{$value['name'] .' - '. $value['symbol']}}</option>
                        @elseif($key == 'USD')
                            <option class="form-control m-input" selected value="{{$key}}">{{$value['name'] .'-'. $value['symbol']}}</option>
                            @else
                            <option class="form-control m-input" value="{{$key}}">{{$value['name'] .'-'. $value['symbol']}}</option>
                        @endif --}}
                    @endforeach
                </select> @if ($errors->has('currency'))
                <p class="form-control-feedback">{{ $errors->first('currency') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('ipfilter_alias_exception')) has-danger @endif d-none">
            {!!Form::label('ipfilter_alias_exception', trans('labels.exception_keyword'),['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-7">

                {!!Form::text('ipfilter_alias_exception',old('ipfilter_alias_exception',$record->sc_ipfilter_alias_exception),['class' => 'form-control m-input','id'=>'ipfilter_alias_exception'])!!} @if ($errors->has('ipfilter_alias_exception'))
                <p class="form-control-feedback">{{ $errors->first('ipfilter_alias_exception') }}</p> @endif

            </div>
        </div>
          <div class="form-group m-form__group row">
                {!!Form::label('desc_bottom',trans('labels.description').' Bottom',['class' => 'col-sm-3 col-form-label'])!!}
                <div class="col-sm-7">
                    {!!Form::textarea('desc_bottom',old('desc_bottom',$record->desc_bottom),['rows' => 8,'class' => 'form-control m-input cms-editor'])!!}
                </div>
          </div>

    </div>
</div>
{!!Form::close()!!} @endsection @push('style')
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
@endpush @push('javascript')


<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>

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

        //validation
    
    });
    {{--  $("#idev-form").validate({

        rules: {
            phone: "number"
        },
        // Specify validation error messages
        messages: {
            phone: {
                number: "this is field input can only number"
            },
        }
    });  --}}
    /*
     $(function() {
         $('body').on('click', '#btnsaveclose', function() {
             var id = $('#id').val();
             var name = $('#name').val();
             var address = $('#address').val();
             var phone = $('#phone').val();
             var sms = $('#sms').val();
             var pinbb = $('#pinbb').val();
             var wechat = $('#wechat').val();
             var line = $('#line').val();
             var facebook = $('#facebook').val();
             var twitter = $('#twitter').val();
             var google = $('#google').val();
             var mail = $('#mail').val();
             var title = $('#title').val();
             var keywords = $('#keywords').val();
             var description = $('#description').val();
             var currency = $('#currency').val();
             var ipfilter_alias_exception = $('#ipfilter_alias_exception').val();

             $.ajax({
                 url: '{{url(_ADMIN_PREFIX_URL."/homesettings/0")}}',
                 method: 'PATCH',
                 dataType: 'JSON',
                 data: {
                     '_token': $('meta[name="csrf-token"]').attr('content'),
                     id,
                     name,
                     address,
                     phone,
                     sms,
                     pinbb,
                     wechat,
                     line,
                     facebook,
                     twitter,
                     google,
                     mail,
                     title,
                     keywords,
                     description,
                     currency,
                     ipfilter_alias_exception
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
     });
     */
</script>
@endpush