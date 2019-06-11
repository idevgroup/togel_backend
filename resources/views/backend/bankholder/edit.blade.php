@extends('backend.template.main')
@push('title',trans('bankholder').'-'.trans('trans.edit'))
@section('content')
{!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/bankaccounts/'.$record->id),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method' => 'PATCH'])!!}
<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

    <div class="m-portlet__head" style="">
        <div class="m-portlet__head-wrapper">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{trans('menu.bankaccount').' / '.trans('trans.edit')}}
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
            {!!Form::label('name','Bank Account Name',['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-5">
                {!!Form::text('name',old('name',$record->name),['class' => 'form-control m-input','id'=>'name'])!!}
                @if ($errors->has('name')) <p class="form-control-feedback">{{ $errors->first('name') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!!Form::label('bank_id','Bank',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                {!!Form::select('bank_id',$bank,old('bank_id',$record->bank_id),['class'=>'form-control m-input'])!!}
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('number')) has-danger @endif">
            {!!Form::label('number','Bank Account number',['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-5">
                {!!Form::text('number',old('number',$record->number),['class' => 'form-control m-input','id'=>'number'])!!}
                @if ($errors->has('number')) <p class="form-control-feedback">{{ $errors->first('number') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('phone')) has-danger @endif">
            {!!Form::label('phone','Phone Number',['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-5">
                {!!Form::text('phone',old('phone',$record->phone),['class' => 'form-control m-input','id'=>'phone'])!!}
                @if ($errors->has('phone')) <p class="form-control-feedback">{{ $errors->first('phone') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('balance')) has-danger @endif">
            {!!Form::label('balance','Balance',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                {!!Form::text('balance',old('balance',$record->balance),['class' => 'form-control m-input','id'=>'balance'])!!}
                @if ($errors->has('balance')) <p class="form-control-feedback">{{ $errors->first('balance') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('address')) has-danger @endif">
            {!!Form::label('address','Address',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                {!!Form::text('address',old('address',$record->address),['class' => 'form-control m-input','id'=>'address'])!!}
                @if ($errors->has('address')) <p class="form-control-feedback">{{ $errors->first('address') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('type')) has-danger @endif">
            {!!Form::label('type','Type',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                {!!Form::text('type',old('type',$record->type),['class' => 'form-control m-input','id'=>'type'])!!}
                @if ($errors->has('type')) <p class="form-control-feedback">{{ $errors->first('type') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!!Form::label('status','Active',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                <input data-switch="true" type="checkbox" value="{{$record->status}}" {{($record->status == 1)?'checked':''}} name="status" data-on-color="success" data-off-color="warning">

            </div>
        </div>
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
$(document).on('click', '#slugupdate', function () {
    //$('#name').furl({id: 'slug', seperate: '-'});
    var Text = $('#name').val();
    Text = Text.toLowerCase();
    var regExp = /\s+/g;
    Text = Text.replace(regExp, '-');
    $("#slug").val(Text);
});

var BootstrapSwitch = {init: function () {
        $("[data-switch=true]").bootstrapSwitch()
    }};
jQuery(document).ready(function () {
    $('#banner').ace_file_input('show_file_list', [{
            type: 'image',
            name: '{{asset($record->thumb)}}'
        }]);
    BootstrapSwitch.init()
});
</script>
@endpush