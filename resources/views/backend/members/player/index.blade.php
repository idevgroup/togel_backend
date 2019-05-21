@extends('backend.template.main')
@push('title',trans('menu.members'))
@section('content')
<div class="m-portlet m-portlet--last m-portlet--head-sm m-portlet--responsive-mobile" >
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{trans('menu.members')}}
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools  ">
          
        </div>

    </div>
    <div class="m-portlet__body">
         {!! $dataTable->table(['class' => 'table table-striped- table-bordered table-hover table-checkable','id'=>'admin-tbl-zen']) !!}
    </div>
</div>
@endsection

@push('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<style>
    .p-name{
        font-weight: 500;
        display: block;
    }
    #admin-tbl-zen tbody td small{
        display: block;
    }
</style>
@endpush
@push('javascript')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

{{--<script src="/vendor/datatables/buttons.server-side.js"></script>--}}
{!! $dataTable->scripts() !!} 
@endpush