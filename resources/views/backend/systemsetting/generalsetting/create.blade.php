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
                    {!!Form::open(['class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form1','files'=>true])!!} {{-- 'url' =>url(_ADMIN_PREFIX_URL.'/messagetemplates/0'), ,'method'=> 'PATCH' --}}
                    <h1>Mail Configuration</h1>
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