@extends('backend.template.main')
@push('title',trans('menu.members'))
@section('content')
<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile"  id="main_portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{trans('menu.mambers')}}
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            @include('backend.shared._actionbtn')
        </div>

    </div>
    <div class="m-portlet__body">
         
    </div>
</div>
@endsection

@push('style')

@endpush
@push('javascript')

@endpush