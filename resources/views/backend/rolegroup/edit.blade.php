@extends('backend.template.main')
@push('title',trans('menu.rolegroup').'-'.trans('trans.create'))
@section('content')
<div class="m-portlet m-portlet--mobile">
    {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/rolegroups/'.$qSelect->id),'class' =>'m-form m-form--fit m-form--label-align-right','method' => 'PATCH'])!!}
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{trans('menu.rolegroup').' / '.trans('trans.edit')}}
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">

        </div>

    </div>
    <div class="m-portlet__body">
        <div class="form-group m-form__group row @if ($errors->has('rolename')) has-danger @endif">
            {!!Form::label('rolename', trans('labels.rolename'),['class' => 'col-2 col-form-label required'])!!}
            <div class="col-5">
                {!!Form::text('rolename',old('rolename',$qSelect->name),['class' => 'form-control m-input'])!!}
                @if ($errors->has('rolename')) <p class="form-control-feedback">{{ $errors->first('rolename') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('rolename')) has-danger @endif">
            {!!Form::label('menu', trans('labels.menuaccess'),['class' => 'col-2 col-form-label required'])!!}
            <div class="col-5">
                {!!Form::select('menu[]',$arrMenu,old('menu',$menuaccess),['class' => 'form-control m-input', 'multiple','size' => '15'])!!}
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!!Form::label('status',trans('labels.status'),['class' => 'col-2 col-form-label'])!!}
            <div class="col-5">
                <span class="m-switch m-switch--outline m-switch--icon m-switch--danger">
                    <label>
                        <input type="checkbox" value="{{$qSelect->status}}" name="status" @if($qSelect->status == 1) checked="checked" @endif >
                        <span></span>
                    </label>
                </span>

            </div>
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <div class="row">
                <div class="col-2">
                </div>
                <div class="col-10">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{trans('labels.submit')}}</button>
                    <button type="reset" class="btn btn-secondary"><i class="fa fa-refresh"></i> {{trans('labels.cancel')}}</button>
                </div>
            </div>
        </div>
    </div>

    {!!Form::close()!!}
</div>

@endsection