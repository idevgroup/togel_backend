@extends('backend.template.main')
@push('title',trans('trans.player').'-'.trans('trans.edit'))
@section('content')
{!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/players',$record->id),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method' => 'PATCH'])!!}

<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">
    <div class="m-portlet__head" style="">
        <div class="m-portlet__head-wrapper">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{trans('trans.player').' / '.trans('trans.edit')}}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                @include('backend.shared._actionform')
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="form-group m-form__group row @if ($errors->has('txtname')) has-danger @endif">
            {!!Form::label('name',trans('labels.playername'),['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-5">
                {!!Form::text('txtname',old('txtname',$record->reg_name),['class' => 'form-control m-input','id'=>'name'])!!}
                @if ($errors->has('txtname')) <p class="form-control-feedback">{{ $errors->first('txtname') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('txtusername')) has-danger @endif">
            {!!Form::label('username',trans('labels.username'),['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-5">
                {!!Form::text('txtusername',old('txtusername',$record->reg_username),['class' => 'form-control m-input','id'=>'username'])!!}
                @if ($errors->has('txtusername')) <p class="form-control-feedback">{{ $errors->first('txtusername') }}</p> @endif
            </div>
        </div>

        <div class="form-group m-form__group row @if ($errors->has('txtpassword')) has-danger @endif">
            {!!Form::label('password',trans('labels.password'),['class' => 'col-sm-3 col-form-label '])!!}
            <div class="col-sm-5">
                {!!Form::password('txtpassword',['class' => 'form-control m-input','id'=>'password'])!!}
                @if ($errors->has('txtpassword')) <p class="form-control-feedback">{{ $errors->first('txtpassword') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('txtconfirm')) has-danger @endif">
            {!!Form::label('confirm',trans('labels.confirmpassword'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                {!!Form::password('txtconfirm',['class' => 'form-control m-input','id'=>'confirm'])!!}
                @if ($errors->has('txtconfirm')) <p class="form-control-feedback">{{ $errors->first('txtconfirm') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('txtemail')) has-danger @endif">
            {!!Form::label('email',trans('labels.email'),['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-5">
                {!!Form::text('txtemail',old('txtemail',$record->reg_email),['class' => 'form-control m-input','id'=>'email','readOnly' => 'true'])!!}
                @if ($errors->has('txtemail')) <p class="form-control-feedback">{{ $errors->first('txtemail') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('txtdob')) has-danger @endif">
            {!!Form::label('dob',trans('labels.dateofbirth'),['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-5">
                <div class="input-group date">
                    {!!Form::text('txtdob',old('txtdob',$record->reg_dob),['class' => 'form-control m-input','id'=>'dob'])!!}
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-calendar"></i>
                        </span>
                    </div>
                </div>
                @if ($errors->has('txtdob')) <p class="form-control-feedback">{{ $errors->first('txtdob') }}</p> @endif
            </div>
        </div>


        <div class="form-group m-form__group row d-none">
            {!!Form::label('address',trans('labels.address'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                {!!Form::text('txtaddress',old('txtaddress'),['class' => 'form-control m-input','id'=>'address'])!!}
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!!Form::label('phone',trans('labels.phone'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                {!!Form::text('txtphone',old('txtphone',$record->reg_phone),['class' => 'form-control m-input','id'=>'address'])!!}
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!!Form::label('status',trans('labels.active'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                <input data-switch="true" type="checkbox" value="0" name="status" @if($record->status == 1) checked @endif data-on-color="success" data-off-color="warning">
            </div>
        </div>
    </div>
</div>

{!!Form::close()!!}
@endsection
@push('javascript')

<script type="text/javascript">

    var BootstrapSwitch = {init: function () {
            $("[data-switch=true]").bootstrapSwitch()
        }};
    jQuery(document).ready(function () {
        BootstrapSwitch.init();
        $('#dob').datepicker({
            todayBtn: "linked",
            clearBtn: true,
            todayHighlight: true,
            format: 'yyyy-mm-dd',
            defaultViewDate: {year: '1970'}
        }).inputmask('yyyy-mm-dd', {
            placeholder: 'yyyy-mm-dd',
            showMaskOnHover: true,
            showMaskOnFocus: true
        });
    });
</script>
@endpush