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
    .dt-buttons .dt-button{
        color: #040404;
        font-weight: 500;
    }
</style>
@endpush
@push('javascript')
<div class="modal fade" id="playerTransaction" tabindex="-1" role="dialog" aria-labelledby="playerTransationTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="playerTransationTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <table class="table table-bordered" id="tableTransation">
                    <thead>
                        <tr>
                            <th>Invoice ID</th>
                            <th>Game Name</th>
                            <th>Market</th>
                            <th>Date/Time</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>

{{--<script src="/vendor/datatables/buttons.server-side.js"></script>--}}
{!! $dataTable->scripts() !!} 
<script>
$(function () {
    $("body").delegate('.player-transaction', 'click', function () {
        var pname = "Transaction << " + $(this).data("pname") + " >>";
        var getPId = $(this).data('id');
        $('#playerTransationTitle').text(pname);

        getTransaction(getPId);
        $('#playerTransaction').modal('show').on('hidden.bs.modal', function (e) {
            $('#tableTransation tbody').remove();

        })
    });

    function getTransaction(pId) {
        $('#tableTransation').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ url(Config::get("sysconfig.prefix")."/players") }}/' + pId,
            columns: [
                {data: 'invoiceId', name: 'invoiceId'},
                {data: 'gameName', name: 'gameName'},
                {data: 'market', name: 'market'},
                {data: 'date', name: 'date'},
                {data: 'debet', name: 'debet'},
                {data: 'kredit', name: 'kredit'},
                {data: 'saldo', name: 'saldo'}
            ],
            bDestroy: true,
            order: [[3, 'DESC']],
            dom: 'Bfrtlip',
            "buttons": [{
                    "extend": "csvHtml5",
                    "text": "<i class=\"fa fa-file-alt\"><\/i><span>CSV<\/span>", 
                    "className": " m-btn--icon"
                }
                , {
                    "extend": "excelHtml5", 
                     "text": "<i class=\"fa fa-file-excel\"><\/i><span>Excel<\/span>",
                     "className": " m-btn--icon"
                }
                , {
                    "extend": "pdfHtml5", 
                    "orientation": "landscape",
                    "pageSize": "A4",
                    "download": "open", 
                    "text": "<i class=\"fa fa-file-pdf\"><\/i><span>PDF<\/span>", 
                    "className": " m-btn--icon", 
                }
                , {
                    "extend": "copyHtml5",
                    "text": "<i class=\"fa fa-copy\"><\/i><span>Copy<\/span>", "className": " m-btn--icon"
                }
                , {
                    "extend": "print", "pageSize": "A4", 
                    "text": "<i class=\"fa fa-print\"><\/i><span>Print<\/span>", 
                    "className": " m-btn--icon"
                }
            ]
        });


    }
});
    </script>

    @endpush
