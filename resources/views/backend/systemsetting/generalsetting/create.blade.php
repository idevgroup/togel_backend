@extends('backend.template.main') @push('title',trans('menu.generalsetting').'-'.trans('trans.create')) @section('content') {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/generalsettings/0'),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method'
=> 'PATCH'])!!}
<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

    <div class="m-portlet__head" style="">
        <div class="m-portlet__head-wrapper">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{trans('menu.generalsetting').' / '.trans('trans.create')}}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                {{-- @include('backend.shared._actionform') --}}
                <button type="submit" name="btnsaveclose" id="btnsaveclose" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                        <span>
                            <i class="fa fa-archive"></i>
                            <span>{{__('trans.btnsave')}}</span>
                        </span>
                    </button>
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        @php($getCurrentCode =Config('sysconfig.currency_code') ) {{-- {{dd($getCurrentCode)}} --}} @if (!$generalSetting->isEmpty()) @foreach($generalSetting as $item)
        <input type="hidden" name="id" id="id" value="{{$item->id}}">
        <div class="form-group m-form__group row @if ($errors->has('currency')) has-danger @endif">
            {!!Form::label('currency','Currency',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
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
        <div class="form-group m-form__group row @if($errors->has('logo')) has-danger @endif">
            {!!Form::label('logo','Logo',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">

                {!!Form::file('logo',['id' =>'logo'])!!} @if ($errors->has('logo'))
                <p class="form-control-feedback">{{ $errors->first('logo') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if($errors->has('icon')) has-danger @endif">
            {!!Form::label('icon','Icon',['class' => 'col-sm-3 col-form-label'])!!}
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
        @endforeach @else
        <input type="hidden" id="id" name="id">
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
        <div class="form-group m-form__group row @if($errors->has('logo')) has-danger @endif">
            {!!Form::label('logo','Logo',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">

                {!!Form::file('logo',['id' =>'logo'])!!} @if ($errors->has('logo'))
                <p class="form-control-feedback">{{ $errors->first('logo') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if($errors->has('icon')) has-danger @endif">
            {!!Form::label('icon','Icon',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">

                {!!Form::file('icon',['id' =>'icon'])!!} @if ($errors->has('icon'))
                <p class="form-control-feedback">{{ $errors->first('icon') }}</p> @endif
            </div>
        </div>
    @endif
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
@endpush @push('javascript') {{--


<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>--}}

<script type="text/javascript" src="{{ asset('backend/assets/jquery.furl.js')}}"></script>
<script type="text/javascript" charset="utf8" src="{{asset('backend/assets/tagsinput/tagsinput.js')}}"></script>
{{--{!!JsValidator::formRequest('App\Http\Requests\CategoriesRequest', '#idev-form')!!}--}} @include('backend.shared._selectimg',['selectElement' => '#logo,#icon']) @include('backend.shared._tinymce',['elements' => '.cms-editor'])
<script type="text/javascript">
    var BootstrapSwitch = {
        init: function() {
            $("[data-switch=true]").bootstrapSwitch()
        }
    };
  
    jQuery(document).ready(function() {
      
            
        BootstrapSwitch.init()
            /*
            var currency = $('#currency').val();
            // var logo = $('#logo')
        
            console.log(currency);
            $('body').on('click', '#btnsaveclose', function() {
                var currency = $('#currency').val();
                var form_data = new FormData();
                var test = form_data.append('#logo', img.files[0]);
                // var icon = new FormData("#icon");
                console.log(test);
                $.ajax({
                    url: '{{ url(_ADMIN_PREFIX_URL."/generalsettings/0") }}',
                    method: 'PATCH',
                    dataType: 'JSON',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        currency,
                        logo
                    },
                    cache: false,
                    contentType: false,
                    processData: false,
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
    });
    
</script>
@endpush