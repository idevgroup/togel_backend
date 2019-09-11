@extends('backend.template.main')
@push('title',trans('menu.result'))
@section('content')
<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile"  id="main_portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{trans('menu.result')}}
                </h3>
            </div>
        </div>   
        <div class="m-portlet__head-tools">
            <button type="button" class="btn m-btn--pill m-btn--air  btn-primary m-btn--wide" data-toggle="modal" data-target="#m_modal_6">Add Result</button>
        </div>
    </div>
    <div class="m-portlet__body">
        {!! $html->table(['class' => 'table table-striped table-bordered table-hover','id'=>'admin-tbl-zen']) !!}
    </div>
    <div class="modal fade" id="m_modal_6" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('style')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" />
<style>
    .m-btn--label-warning i{
        color: darkcyan !important;
    }
    .m-btn--label-danger i{
        color: darkred !important;
    }
</style>
@endpush
@push('javascript')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
{!! $html->scripts() !!} 
<script>
var tbladmin = 'admin-tbl-zen';
$(document).ready(function () {
    $('<label  style="margin-left: 10px;">- Filter By: ' +
            '{!!Form::select("market",$marketGame,0,["class"=>"form-control form-control-sm","id" => "market"])!!}' +
            '</label>').appendTo("#admin-tbl-zen_length");
});

$('body').on('change', '#market', function () {
    window.LaravelDataTables[tbladmin].draw();
})
</script>

@endpush
