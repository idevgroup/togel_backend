@extends('backend.template.main')
@push('title',trans('menu.software').'-'.trans('trans.edit'))
@section('content')
    {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/software/'.$record->id),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method' => 'PATCH'])!!}
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

        <div class="m-portlet__head" style="">
            <div class="m-portlet__head-wrapper">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{trans('menu.software').' / '.trans('trans.edit')}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    @include('backend.shared._actionform')
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <input type="hidden" value="{{ Auth::user()->id }}" name="user_id">
            <div class="form-group m-form__group row @if ($errors->has('name')) has-danger @endif">
                {!!Form::label('name','Name',['class' => 'col-sm-3 col-form-label required'])!!}
                <div class="col-sm-5">
                    {!!Form::text('name',old('name',$record->name),['class' => 'form-control m-input','id'=>'name'])!!}
                    @if ($errors->has('name')) <p
                            class="form-control-feedback">{{ $errors->first('name') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('txtslug')) has-danger @endif">
                {!!Form::label('slug','Slug',['class' => 'col-sm-3 col-form-label required'])!!}
                <div class="col-sm-5">
                    <div class="input-group">
                        {!!Form::text('slug',old('slug',$record->slug),['class' => 'form-control m-input','id' => 'slug' ,'readOnly'])!!}
                        <div class="input-group-append">
                            <button class="btn btn-info" type="button" id="slugupdate">Update Slug</button>
                        </div>
                    </div>
                    @if ($errors->has('txtslug')) <p
                            class="form-control-feedback">{{ $errors->first('txtslug') }}</p> @endif
                </div>

            </div>
            <div class="form-group m-form__group row @if($errors->has('filepath')) has-danger @endif">
                {!!Form::label('filepath','File',['class' => 'col-sm-3 col-form-label required'])!!}
                <div class="col-sm-5">
                    <div class="row">
                        <div class="col-sm-3">
                         <span class="input-group-btn btn-span">
                             <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                               <i class="fa fa-picture-o"></i> Choose
                             </a>
                        </span>
                        </div>
                        <div class="col-sm-9">
                            <input id="thumbnail" class="form-control filepath" type="text" name="filepath"
                                   value="{{$record->file}}">
                        </div>
                    </div>
                    @if ($errors->has('filepath')) <p
                            class="form-control-feedback">{{ $errors->first('filepath') }}</p> @endif
                </div>
                <img id="holder" style="margin-top:15px;max-height:90px;">
            </div>
            <div class="form-group m-form__group row">
                {!!Form::label('short_description','Brief',['class' => 'col-sm-3 col-form-label'])!!}
                <div class="col-sm-7">
                    {!!Form::textarea('short_description',old('short_description',$record->short_description),['rows' => 8,'class' => 'form-control m-input cms-editor'])!!}
                </div>
            </div>
            <div class="form-group m-form__group row">
                {!!Form::label('description','Description',['class' => 'col-sm-3 col-form-label'])!!}
                <div class="col-sm-7">
                    {!!Form::textarea('description',old('description',$record->description),['rows' => 8,'class' => 'form-control m-input cms-editor'])!!}
                </div>
            </div>
            <div class="form-group m-form__group row @if($errors->has('bannerfile')) has-danger @endif">
                {!!Form::label('banner','Banner',['class' => 'col-sm-3 col-form-label'])!!}
                <div class="col-sm-5">

                    {!!Form::file('bannerfile',['id' =>'banner'])!!}
                    @if ($errors->has('bannerfile')) <p
                            class="form-control-feedback">{{ $errors->first('bannerfile') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                {!!Form::label('status','Active',['class' => 'col-sm-3 col-form-label'])!!}
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

        /*.btn-span{*/
        /*    position: absolute;*/
        /*}*/
        /*.filepath{*/
        /*    width: 500px;*/
        /*    margin-left: 90px;*/
        /*}*/
    </style>
@endpush
@push('javascript')


    {{--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>--}}

    <script type="text/javascript" src="{{ asset('backend/assets/jquery.furl.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('backend/assets/tagsinput/tagsinput.js')}}"></script>
    {{--{!!JsValidator::formRequest('App\Http\Requests\CategoriesRequest', '#idev-form')!!}--}}
    @include('backend.shared._selectimg',['selectElement' => '#banner'])
    @include('backend.shared._tinymce',['elements' => '.cms-editor'])
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
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
            BootstrapSwitch.init()
        });
        var domain = "";
        $('#lfm').filemanager('file', {prefix: domain});
        var lfm = function (options, cb) {

            var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';

            window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600,margin-left: 500px');
            window.SetUrl = cb;
        }
    </script>
@endpush