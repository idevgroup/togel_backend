@extends('backend.template.main')
@push('title',trans('menu.bankgroup').'-'.trans('trans.create'))
@section('content')
    {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/bankgroupps'),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true])!!}
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

        <div class="m-portlet__head" style="">
            <div class="m-portlet__head-wrapper">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{trans('menu.bankgroup').' / '.trans('trans.create')}}
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
                {!!Form::label('name', trans('labels.name'),['class' => 'col-sm-3 col-form-label required'])!!}
                <div class="col-sm-5">
                    {!!Form::text('name',old('name'),['class' => 'form-control m-input','id'=>'name','required' => true])!!}
                    @if ($errors->has('name')) <p class="form-control-feedback">{{ $errors->first('name') }}</p> @endif
                </div>
            </div> 
            <div class="form-group m-form__group row">
                {!!Form::label('status', trans('labels.active'),['class' => 'col-sm-3 col-form-label'])!!}
                <div class="col-sm-5">
                    <input data-switch="true" type="checkbox" value="0" name="status" data-on-color="success"
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
            $("#name").focus();
            //validation
            $("#idev-form").validate({

                rules: {
                    name: "required",
                   
                },
                // Specify validation error messages
                messages: {
                    name: "Please Input Group Name",
                  
                }
            });
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