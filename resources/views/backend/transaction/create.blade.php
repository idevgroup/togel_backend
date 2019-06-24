@extends('backend.template.main')
@push('title',trans('menu.transactionlimitation').'-'.trans('trans.create'))
@section('content')
    {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/transactionlimits/0'),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method' => 'PATCH'])!!}
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

        <div class="m-portlet__head" style="">
            <div class="m-portlet__head-wrapper">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{trans('menu.transactionlimitation').' / '.trans('trans.create')}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    @include('backend.shared._actionform')
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="m-portlet__body">
                <div class="form-group m-form__group row">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h5 class="m-portlet__head-text">
                                Deposit
                            </h5>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="form-group m-form__group row @if ($errors->has('dep_min')) has-danger @endif">
                    {!!Form::label('dep_min','Minimum *',['class' => 'col-sm-3 col-form-label'])!!}
                    <div class="col-sm-6">
                        {!!Form::text('dep_min',old('dep_min',$transaction->dep_min),['class' => 'form-control m-input','id'=>'dep_min'])!!}
                        @if ($errors->has('dep_min')) <p
                                class="form-control-feedback">{{ $errors->first('dep_min') }}</p> @endif
                    </div>
                </div>

                <div class="form-group m-form__group row @if ($errors->has('dep_max')) has-danger @endif">
                    {!!Form::label('dep_max','Maximum *',['class' => 'col-sm-3 col-form-label'])!!}
                    <div class="col-sm-6">
                        {!!Form::text('dep_max',old('dep_max',$transaction->dep_max),['class' => 'form-control m-input','id'=>'dep_max'])!!}
                        @if ($errors->has('dep_max')) <p
                                class="form-control-feedback">{{ $errors->first('dep_max') }}</p> @endif
                    </div>
                </div>
                <div class="form-group m-form__group row">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h5 class="m-portlet__head-text">
                                Withdraw
                            </h5>
                        </div>
                    </div>
                </div>
                <hr/>
                <div class="form-group m-form__group row @if ($errors->has('with_min')) has-danger @endif">
                    {!!Form::label('with_min','Minimum *',['class' => 'col-sm-3 col-form-label'])!!}
                    <div class="col-sm-6">
                        {!!Form::text('with_min',old('with_min',$transaction->with_min),['class' => 'form-control m-input','id'=>'with_min'])!!}
                        @if ($errors->has('with_min')) <p
                                class="form-control-feedback">{{ $errors->first('with_min') }}</p> @endif
                    </div>
                </div>

                <div class="form-group m-form__group row @if ($errors->has('with_max')) has-danger @endif">
                    {!!Form::label('with_max','Maximum *',['class' => 'col-sm-3 col-form-label'])!!}
                    <div class="col-sm-6">
                        {!!Form::text('with_max',old('with_max',$transaction->with_max),['class' => 'form-control m-input','id'=>'with_max'])!!}
                        @if ($errors->has('with_max')) <p
                                class="form-control-feedback">{{ $errors->first('with_max') }}</p> @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
    {!!Form::close()!!}
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('backend/assets/fileinput/fileinput.css')}}"/>
    <link rel="stylesheet" href="{{asset('backend/assets/tagsinput/tagsinput.css')}}"/>
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
@endpush
@push('javascript')


    {{--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>--}}

    <script type="text/javascript" src="{{ asset('backend/assets/jquery.furl.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('backend/assets/tagsinput/tagsinput.js')}}"></script>
    {{--{!!JsValidator::formRequest('App\Http\Requests\CategoriesRequest', '#idev-form')!!}--}}
    @include('backend.shared._selectimg',['selectElement' => '#banner'])
    @include('backend.shared._tinymce',['elements' => '.cms-editor'])
    <script type="text/javascript">
        var BootstrapSwitch = {
            init: function () {
                $("[data-switch=true]").bootstrapSwitch()
            }
        };
        jQuery(document).ready(function () {
            BootstrapSwitch.init();

            var dep_min = $('#dep_min').val();
           var test = dep_min.defaultFormat('$0,0.00');
            console.log(test);

        });
    </script>
@endpush