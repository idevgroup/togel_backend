@extends('backend.template.main')
@push('title',trans('menu.category').'-'.trans('trans.create'))
@section('content')
{!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/categories'),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form'])!!}
<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

    <div class="m-portlet__head" style="">
        <div class="m-portlet__head-wrapper">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{trans('menu.category').' / '.trans('trans.create')}}
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
            {!!Form::label('name','Category Name',['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-5">
                {!!Form::text('txtname',old('txtname'),['class' => 'form-control m-input','id'=>'name'])!!}
                @if ($errors->has('txtname')) <p class="form-control-feedback">{{ $errors->first('txtname') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('txtslug')) has-danger @endif">
            {!!Form::label('slug','Slug',['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-5">
                {!!Form::text('txtslug',old('txtslug'),['class' => 'form-control m-input','id' => 'slug' ])!!}
                @if ($errors->has('txtslug')) <p
                    class="form-control-feedback">{{ $errors->first('txtslug') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!!Form::label('parent','Is Parent',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                {!!Form::select('parent',$get_parent,old('parent'),['class'=>'form-control m-input'])!!}
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
                {!!Form::textarea('shortdesc',old('shortdesc'),['rows' => 8,'class' => 'form-control m-input cms-editor'])!!}
            </div>
        </div>

        <div class="form-group m-form__group row">
            {!!Form::label('status','Active',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                <span class="m-switch m-switch--icon m-switch--accent">
                    <label>
                        <input type="checkbox" value="0" name="status">
                        <span></span>
                    </label>
                </span>
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!!Form::label('metakey','Meta Key',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                {!!Form::text('txtmetakey',old('txtmetakey'),['class' => 'form-control m-input','id' => 'metakeyword'])!!}
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!!Form::label('metadesc','Meta Description',['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-5">
                {!!Form::textarea('txtmetadesc',old('txtmetadesc'),['class' => 'form-control m-input'])!!}
            </div>
        </div>
    </div>

</div>
{!!Form::close()!!}
@endsection
@push('style')
<link rel="stylesheet" href="{{asset('backend/assets/fileinput/fileinput.css')}}" />
@endpush
@push('javascript')

<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('backend/assets/jquery.furl.js')}}"></script>
{!!JsValidator::formRequest('App\Http\Requests\CategoriesRequest', '#idev-form')!!}
@include('backend.shared._selectimg',['selectElement' => '#banner'])
@include('backend.shared._tinymce',['elements' => '.cms-editor'])
<script type="text/javascript">
$('#name').furl({id: 'slug', seperate: '-'});
</script>
@endpush