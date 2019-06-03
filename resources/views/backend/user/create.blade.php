@extends('backend.template.main')
@push('title',trans('menu.user').'-'.trans('trans.create'))
@section('content')
<div class="m-portlet m-portlet--mobile">
    {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/useraccounts'),'class' =>'m-form  m-form--state m-form--fit m-form--label-align-right'])!!}
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{trans('menu.user').' / '.trans('trans.create')}}
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">

        </div>

    </div>
    <div class="m-portlet__body">
        <!-- Name Form Input -->
        <div class="form-group m-form__group row @if ($errors->has('name')) has-danger @endif">
            {!! Form::label('name', 'Name',['class' => 'col-2 col-form-label required']) !!}
            <div class="col-5">
                {!! Form::text('name', old('name'), ['class' => 'form-control m-input', 'placeholder' => 'Name']) !!}
                @if ($errors->has('name')) <p class="form-control-feedback">{{ $errors->first('name') }}</p> @endif
            </div>
        </div>
       <div class="form-group m-form__group row @if ($errors->has('username')) has-danger @endif">
            {!! Form::label('username', 'User Name',['class' => 'col-2 col-form-label required']) !!}
            <div class="col-5">
                {!! Form::text('username',old('username'), ['class' => 'form-control m-input', 'placeholder' => 'User Name']) !!}
                @if ($errors->has('username')) <p class="form-control-feedback">{{ $errors->first('username') }}</p> @endif
            </div>
        </div>
        <!-- email Form Input -->
        <div class="form-group m-form__group row @if ($errors->has('email')) has-danger @endif">
            {!! Form::label('email', 'Email',['class' => 'col-2 col-form-label required']) !!}
            <div class="col-5">
                {!! Form::text('email', null, ['class' => 'form-control m-input', 'placeholder' => 'Email']) !!}
                @if ($errors->has('email')) <p class="form-control-feedback">{{ $errors->first('email') }}</p> @endif
            </div>
        </div>

        <!-- password Form Input -->
        <div class="form-group m-form__group row @if ($errors->has('password')) has-danger @endif">
            {!! Form::label('password', 'Password',['class' => 'col-2 col-form-label required']) !!}
            <div class="col-5">
                {!! Form::password('password', ['class' => 'form-control m-input', 'placeholder' => 'Password']) !!}
                @if ($errors->has('password')) <p class="form-control-feedback">{{ $errors->first('password') }}</p> @endif
            </div>
        </div>
        <!-- Roles Form Input -->
        <div class="form-group m-form__group row @if ($errors->has('roles')) has-danger @endif">
            {!! Form::label('roles[]', 'Roles',['class' => 'col-2 col-form-label required']) !!}
            <div class="col-5">
                {!! Form::select('roles[]', $roles, old('roles'),  ['class' => 'form-control m-input']) !!}
                @if ($errors->has('roles')) <p class="form-control-feedback">{{ $errors->first('roles') }}</p> @endif
            </div>
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <div class="row">
                <div class="col-2">
                </div>
                <div class="col-10">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{trans('trans.btnsave')}}</button>
                    <button type="reset" class="btn btn-secondary"><i class="flaticon-refresh"></i> {{trans('trans.btnrefresh')}}</button>
                </div>
            </div>
        </div>
    </div>
    {!!Form::close()!!}
</div>


@endsection