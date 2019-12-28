@extends('backend.template.main')
@push('title',trans('menu.bankgroup').'-'.trans('trans.edit'))
@section('content')
    {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/bankgroupps/'.$record->id),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method' => 'PATCH'])!!}
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

        <div class="m-portlet__head" style="">
            <div class="m-portlet__head-wrapper">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{trans('menu.bankgroup').' / '.trans('trans.edit')}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    @include('backend.shared._actionform')
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="form-group m-form__group row @if ($errors->has('name')) has-danger @endif">
                {!!Form::label('name',  trans('labels.name'),['class' => 'col-sm-3 col-form-label required'])!!}
                <div class="col-sm-5">
                    {!!Form::text('name',old('name',$record->name),['class' => 'form-control m-input','id'=>'name'])!!}
                    @if ($errors->has('name')) <p class="form-control-feedback">{{ $errors->first('name') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                {!!Form::label('status', trans('labels.active'),['class' => 'col-sm-3 col-form-label'])!!}
                <div class="col-sm-5">
                    <input data-switch="true" type="checkbox" value="{{$record->status}}"
                           {{($record->status == 1)?'checked':''}} name="status" data-on-color="success"
                           data-off-color="warning">

                </div>
            </div>
        </div>

    </div>
    {!!Form::close()!!}
@endsection

@push('javascript')


    <script type="text/javascript">
        var BootstrapSwitch = {
            init: function () {
                $("[data-switch=true]").bootstrapSwitch()
            }
        };
         jQuery(document).ready(function () {
            BootstrapSwitch.init();
        })
    </script>    
 @endpush       
