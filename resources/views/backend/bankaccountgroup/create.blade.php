@extends('backend.template.main')
@push('title',trans('bankaccountgroup').'-'.trans('trans.create'))
@section('content')
    {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/bankaccountgroups'),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true])!!}
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

        <div class="m-portlet__head" style="">
            <div class="m-portlet__head-wrapper">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{trans('menu.bankaccountgroup').' / '.trans('trans.create')}}
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
                {!!Form::label('name','Name',['class' => 'col-sm-3 col-form-label required'])!!}
                <div class="col-sm-5">
                    {!!Form::text('name',old('name'),['class' => 'form-control m-input','id'=>'name'])!!}
                    @if ($errors->has('name')) <p class="form-control-feedback">{{ $errors->first('name') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('bank_holder_id')) has-danger @endif">
                {!!Form::label('bank_holder_id','Bank Holder',['class' => 'col-sm-3 col-form-label required'])!!}
                <div class="col-sm-5">
                    {!!Form::select('bank_holder_id',$bank_holder_id,old('bank_holder_id'),['class'=>'form-control m-input'])!!}
                </div>
            </div>
{{--            @foreach ($bank_acc_group as $test)--}}
{{--                {{ $test->bank_id }}--}}
{{--            @endforeach--}}
            <div class="form-group m-form__group row @if ($errors->has('bank_id')) has-danger @endif">
                {!!Form::label('bank_id','Bank',['class' => 'col-sm-3 col-form-label required'])!!}
                <div class="col-sm-5">
                    {{--                    <select class="selectpicker form-control m-input" multiple name="bank_id[]" id="bank_id">--}}
                    {{--                        @foreach($bank_id as $item)--}}
                    {{--                            <option value="{{ $item->id }}">{{ $item->name }}</option>--}}
                    {{--                        @endforeach--}}
                    {{--                    </select>--}}
                    {!!Form::select('bank_id',$bank_id,old('bank_id'),['class'=>'form-control m-input'])!!}
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('deposit_min')) has-danger @endif">
                {!!Form::label('deposit_min','Deposit Minimum',['class' => 'col-sm-3 col-form-label'])!!}
                <div class="col-sm-5">
                    {!!Form::text('deposit_min',old('deposit_min'),['class' => 'form-control m-input','id'=>'deposit_min'])!!}
                    @if ($errors->has('deposit_min')) <p
                            class="form-control-feedback">{{ $errors->first('deposit_min') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('deposit_max')) has-danger @endif">
                {!!Form::label('deposit_max','Deposit Maximum',['class' => 'col-sm-3 col-form-label'])!!}
                <div class="col-sm-5">
                    {!!Form::text('deposit_max',old('deposit_max'),['class' => 'form-control m-input','id'=>'deposit_max'])!!}
                    @if ($errors->has('deposit_max')) <p
                            class="form-control-feedback">{{ $errors->first('deposit_max') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('withdraw_min')) has-danger @endif">
                {!!Form::label('withdraw_min','Withdraw Minimum',['class' => 'col-sm-3 col-form-label'])!!}
                <div class="col-sm-5">
                    {!!Form::text('withdraw_min',old('withdraw_min'),['class' => 'form-control m-input','id'=>'withdraw_min'])!!}
                    @if ($errors->has('withdraw_min')) <p
                            class="form-control-feedback">{{ $errors->first('withdraw_min') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('withdraw_max')) has-danger @endif">
                {!!Form::label('withdraw_max','Withdraw Maximum',['class' => 'col-sm-3 col-form-label'])!!}
                <div class="col-sm-5">
                    {!!Form::text('withdraw_max',old('withdraw_max'),['class' => 'form-control m-input','id'=>'withdraw_max'])!!}
                    @if ($errors->has('withdraw_max')) <p
                            class="form-control-feedback">{{ $errors->first('withdraw_max') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                {!!Form::label('status','Active',['class' => 'col-sm-3 col-form-label'])!!}
                <div class="col-sm-5">
                    <input data-switch="true" type="checkbox" value="0" name="status" data-on-color="success"
                           data-off-color="warning">

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
            // $("#name").focus();
            //validation
            // $("#idev-form").validate({
            //
            //     rules: {
            //         name: "required",
            //         number:{
            //             required: true,
            //             number: true
            //         },
            //         phone:{
            //             required: true,
            //             number: true
            //         },
            //         balance:{
            //             number: true
            //         }
            //     },
            //     // Specify validation error messages
            //     messages: {
            //         name: "Please Input Account Name",
            //         number:{
            //             required: "Please Input Account Number",
            //             number: "Input Only Number"
            //         },
            //         phone:{
            //             required: "Please Input Account Number",
            //             number: "Input Only Number"
            //         },
            //         balance:{
            //             number: "Input Only Number"
            //         }
            //     }
            // });
        });

        // $(document).ready(function () {
        //     $("#idev-form").submit(function(e) {
        //         e.preventDefault();
        //     }).validate({
        //         rules: {
        //             name: "required",
        //         },
        //         // Specify validation error messages
        //         messages: {
        //             name: "Please enter Input Account Name",
        //         }
        //     });
        // })
    </script>
@endpush