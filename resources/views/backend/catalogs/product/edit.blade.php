@extends('backend.template.main')
@push('title',trans('menu.product').'-'.trans('trans.edit'))
@section('content')
{!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/products/'.$product->id),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method' => 'PATCH'])!!}
<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

    <div class="m-portlet__head" style="">
        <div class="m-portlet__head-wrapper">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{trans('menu.product').' / '.trans('trans.edit')}}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                @include('backend.shared._actionform')
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        <input type="hidden" value="{!! Auth::user()->id !!}" name="user_id">
        <div class="form-group m-form__group row @if ($errors->has('txtname')) has-danger @endif">
            {!!Form::label('name','Product Name',['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-5">
                {!!Form::text('txtname',old('txtname',$product->name),['class' => 'form-control m-input','id'=>'name'])!!}
                @if ($errors->has('txtname')) <p class="form-control-feedback">{{ $errors->first('txtname') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('txtslug')) has-danger @endif">
            {!!Form::label('slug','Slug',['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-5">
                <div class="input-group">
                {!!Form::text('txtslug',old('txtslug',$product->slug),['class' => 'form-control m-input','id' => 'slug' ,'readOnly'])!!}
                <div class="input-group-append">
                    <button class="btn btn-info" type="button" id="slugupdate">Update Slug</button>
                </div>
                </div>
                @if ($errors->has('txtslug')) <p
                    class="form-control-feedback">{{ $errors->first('txtslug') }}</p> @endif
            </div>

        </div>
        <div class="form-group m-form__group row">
            {!!Form::label('category_id','Category',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                {!!Form::select('category_id',$get_parent,old('category_id',$product->category_id),['class'=>'form-control m-input'])!!}
            </div>
        </div>
        <div class="form-group m-form__group row @if($errors->has('bannerfile')) has-danger @endif">
            {!!Form::label('banner','Banner',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">

                {!!Form::file('bannerfile',['id' =>'banner'])!!}
                @if ($errors->has('bannerfile')) <p class="form-control-feedback">{{ $errors->first('bannerfile') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!!Form::label('shortdesc','Description',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                {!!Form::textarea('shortdesc',old('shortdesc',$product->description),['rows' => 8,'class' => 'form-control m-input cms-editor'])!!}
            </div>
        </div>

        <div class="form-group m-form__group row">
            {!!Form::label('status','Active',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                <input data-switch="true" type="checkbox" value="{{$product->status}}" {{($product->status == 1)?'checked':''}} name="status" data-on-color="success" data-off-color="warning">

            </div>
        </div>
        <div class="form-group m-form__group row">
            {!!Form::label('metakey','Meta Key',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                {!!Form::text('txtmetakey',old('txtmetakey',$product->meta_key),['class' => 'form-control m-input','id' => 'metakeyword','data-role'=> 'tagsinput'])!!}
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!!Form::label('metadesc','Meta Description',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                {!!Form::textarea('txtmetadesc',old('txtmetadesc',$product->meta_desc),['class' => 'form-control m-input'])!!}
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
            name: '{{asset($product->thumb)}}'
        }]);
    BootstrapSwitch.init()
});
</script>
@endpush