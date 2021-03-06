@extends('backend.template.main')
@push('title',trans('menu.bankholder').'-'.trans('trans.edit'))
@section('content')
    {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/bankholders/'.$record->id),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method' => 'PATCH'])!!}
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

        <div class="m-portlet__head" style="">
            <div class="m-portlet__head-wrapper">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{trans('menu.bankholder').' / '.trans('trans.edit')}}
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
                {!!Form::label('name',  trans('labels.bankholdername'),['class' => 'col-sm-3 col-form-label required'])!!}
                <div class="col-sm-5">
                    {!!Form::text('name',old('name',$record->name),['class' => 'form-control m-input','id'=>'name'])!!}
                    @if ($errors->has('name')) <p class="form-control-feedback">{{ $errors->first('name') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('email')) has-danger @endif">
                {!!Form::label('email', trans('labels.email'),['class' => 'col-sm-3 col-form-label required'])!!}
                <div class="col-sm-5">
                    {!!Form::email('email',old('email',$record->email),['class' => 'form-control m-input','id'=>'email'])!!}
                    @if ($errors->has('email')) <p
                            class="form-control-feedback">{{ $errors->first('email') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('phone')) has-danger @endif">
                {!!Form::label('phone', trans('labels.phone'),['class' => 'col-sm-3 col-form-label required'])!!}
                <div class="col-sm-5">
                    {!!Form::text('phone',old('phone',$record->phone),['class' => 'form-control m-input','id'=>'phone'])!!}
                    @if ($errors->has('phone')) <p
                            class="form-control-feedback">{{ $errors->first('phone') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('position')) has-danger @endif">
                {!!Form::label('position', trans('labels.position'),['class' => 'col-sm-3 col-form-label required'])!!}
                <div class="col-sm-5">
                    {!!Form::text('position',old('position',$record->position),['class' => 'form-control m-input','id'=>'position'])!!}
                    @if ($errors->has('position')) <p
                            class="form-control-feedback">{{ $errors->first('position') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                {!!Form::label('gender', trans('labels.gender'),['class' => 'col-sm-3 col-form-label'])!!}
                <div class="col-sm-5">
                    {{--                {!!Form::select('gender',$record,old('gender',$record->gender),['class'=>'form-control m-input'])!!}--}}
                    <select class="form-control" name="gender">
                        {{--                    <option>Select</option>--}}
                        <option value="male" {!!$record?$record->gender=='male' ?'selected':'':''!!}>Male</option>
                        <option value="famale" {!!$record?$record->gender=='famale' ?'selected':'':''!!}>Famale</option>
                    </select>
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('dob')) has-danger @endif">
                {!!Form::label('dob', trans('labels.dateofbirth'),['class' => 'col-sm-3 col-form-label required'])!!}
                <div class="col-sm-5">
                    <div class="input-group date">
                        {!!Form::text('dob',old('dob',$record->dob),['class' => 'form-control m-input','id'=>'dob'])!!}
                        <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="la la-calendar"></i>
                        </span>
                        </div>
                    </div>
                    @if ($errors->has('txtdob')) <p
                            class="form-control-feedback">{{ $errors->first('txtdob') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row @if($errors->has('photo')) has-danger @endif">
                {!!Form::label('photo', trans('labels.profilepicture'),['class' => 'col-sm-3 col-form-label'])!!}
                <div class="col-sm-5">

                    {!!Form::file('photo',['id' =>'banner'])!!}
                    @if ($errors->has('photo')) <p class="form-control-feedback">{{ $errors->first('photo') }}</p> @endif
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
        $(document).on('click', '#slugupdate', function () {
            //$('#name').furl({id: 'slug', seperate: '-'});
            var Text = $('#name').val();
            Text = Text.toLowerCase();
            var regExp = /\s+/g;
            Text = Text.replace(regExp, '-');
            $("#slug").val(Text);
        });

        var BootstrapSwitch = {
            init: function () {
                $("[data-switch=true]").bootstrapSwitch()
            }
        };
        jQuery(document).ready(function () {
            $('#banner').ace_file_input('show_file_list', [{
                type: 'image',
                name: '{{asset($record->thumb)}}'
            }]);
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
            BootstrapSwitch.init()
        });
    </script>
@endpush