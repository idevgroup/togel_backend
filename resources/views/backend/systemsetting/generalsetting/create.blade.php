@extends('backend.template.main')
@push('title',trans('menu.generalsetting').'-'.trans('trans.create'))
@section('content')
    {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/generalsettings/0'),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method' => 'PATCH'])!!}
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
                    {{--  @include('backend.shared._actionform')  --}}
                    <button type="button" name="btnsaveclose" id="btnsaveclose" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                        <span>
                            <i class="fa fa-archive"></i>
                            <span>{{__('trans.btnsave')}}</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">            
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
    </script>
@endpush