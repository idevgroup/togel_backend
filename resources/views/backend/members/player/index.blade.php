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
            @include('backend.shared._actionbtn')
        </div>

    </div>
    <div class="m-portlet__body">

        <div class="form-group m-form__group row">

            {!!Form::label('filter','Filter:',['class' => 'col-lg-1 col-form-label'])!!}
            <div class="col-lg-2">
                {!!Form::select('status',Config('sysconfig.status'),null,['class' => 'form-control','id' =>'status'])!!}
            </div>

        </div>
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
    #edit-balance{
        margin-left: 15px;
        cursor: pointer;

    }
    #edit-balance:hover{
        color: #003eff !important;
    }
    .modal-full {
    min-width: 90%;
   
}
</style>
@endpush
@push('javascript')
<div class="modal fade" id="playerTransaction" tabindex="-1" role="dialog" aria-labelledby="playerTransationTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="playerTransationTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" >
                <div class="form-group m-form__group row">
                    
                    <div class="col-lg-4 col-sm-12 mx-auto">
                        <div class="input-daterange input-group" id="date-transaction">
                            <input type="text" class="form-control m-input" name="start">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-exchange-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" name="end">

                        </div>
                    </div>
                </div>
                <table class="table table-bordered" id="tableTransation">
                    <thead>
                        <tr>
                            <th>Trans-ID</th>
                            <th>Description</th>
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
<div class="modal fade" id="playerBank" tabindex="-1" role="dialog" aria-labelledby="playerBankTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="playerBankTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bank-info" >

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
var tbladmin = 'admin-tbl-zen';
    </script>
    <script>
        $(function () {

            $("body").delegate('.player-transaction', 'click', function () {
                var pname = "Transaction << " + $(this).data("pname") + " >>";
                var getPId = $(this).data('id');
                $('#playerTransationTitle').text(pname);
                $('input[name="start"]').val('{{date("Y-m-d", strtotime("-7 days"))}}');
                $('input[name="end"]').val('{{date("Y-m-d")}}');
                $('input[name="start"],input[name="end"]').off('blur');
                $('#playerTransaction').modal('show').on('hidden.bs.modal', function (e) {
                    $('#tableTransation tbody').remove();
                    $("#date-transaction").datepicker("destroy");
                });
                $("#date-transaction").datepicker({
                    todayHighlight: true,
                    format: 'yyyy-mm-dd',
                });
                getTransaction(getPId);

            });
            $('body').on('click', '.player-banking', function () {
                var pname = "Player Name << " + $(this).data("pname") + " >>";
                var getPId = $(this).data('id');
                $('#playerBankTitle').text(pname);
                $.ajax({
                    url: '{{url(_ADMIN_PREFIX_URL."/players/banking")}}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {'_token': $('meta[name="csrf-token"]').attr('content'), 'pId': getPId},
                    success: function (response) {
                        var balance = response.balance;
                        var htmlForm = '<div class="form-group m-form__group"><label for="bank-balance-player">Update Balance</label><div class="input-group m-input-group m-input-group--air">' +
                                '<div class="input-group-prepend"><span class="input-group-text"><i class="la la-money"></i></span></div>' +
                                '<input type="number" class="form-control m-input" value="" placeholder="0.00" id="input-amount">' +
                                '<select class="form-control m-input" id="operator"><option value="1">Addition</option><option value="2">Subtract </option></select>' +
                                '<input type="text" class="form-control m-input" value="" placeholder="Description" id="desc-balance">'+
                                '<input type="hidden" value="'+getPId+'" id="pid-balance">'+
                                '<div class="input-group-append">' +
                                '<button class="btn btn-primary" id="update-balance" type="button">Update</button>' +
                                '</div>' +
                                '</div>';
                        var tbl = '<div><h5 id="remain-balance">Balance: ' + balance + ' </h5> </div> <table class="table table-bordered"><thead><tr><th>Bank Name</th><th>Account Name</th><th>Account ID</th></tr></thead>';
                        var tblBody = '<tbody>';
                        var record = response.record;
                        console.log(record);
                        for (i = 0; i < record.length; i++) {
                            tblBody += '<tr>' + '<td>' + record[i]['get_bank']['bk_name'] + '</td>' + '<td>' + record[i]['reg_account_name'] + '</td>' + '<td>' + record[i]['reg_account_number'] + '</td>' + '</tr>';
                        }
                        var htmlTable = tbl + tblBody + '</tbody></table>' + htmlForm;
                        $('#bank-info').html(htmlTable);
                        $('#playerBank').modal('show').on('hidden.bs.modal', function (e) {
                            $('#bank-info').html('');
                        });
                    }
                });

            });
            $('body').on('click', '#update-balance', function () {
               var amount = $('#input-amount').val();
               var operator = $('#operator').val();
               var descBalance = $('#desc-balance').val();
               var pId = $('#pid-balance').val();
               $.ajax({
                    url: '{{url(_ADMIN_PREFIX_URL."/players/updatebalance")}}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {'_token': $('meta[name="csrf-token"]').attr('content'),pId,amount,operator,descBalance},
                    success: function (response) {
                         swal({
                            title: response.title,
                            html: response.message,
                            type: response.status,
                            allowOutsideClick: false
                        });
                        $('#remain-balance').text('Balance: '+response.balance);
                        $('#input-amount').val('');
                        $('#desc-balance').val('');
                        $('#operator').prop('selectedIndex',0);
                        window.LaravelDataTables[tbladmin].draw(false);
                    }
               });
               
            });
            function getTransaction(pId) {
                var table = $('#tableTransation').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ url(Config::get("sysconfig.prefix")."/players") }}/' + pId,
                        data: function (data) {
                            var start = $('input[name="start"]').val();
                            var end = $('input[name="end"]').val();
                            data.searchByStart = start;
                            data.searchByEnd = end;
                        }
                    },
                    language: {
                        paginate: {
                            next: '<i class="la la-angle-right"></i>',
                            previous: '<i class="la la-angle-left"></i>'
                        }
                    },
                    columns: [
                        {data: 'transid', name: 'transid'},
                        {data: 'descrtion', name: 'descrtion'},
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
                    ],
                    columnDefs:[{
                        className: "dt-right", "targets": [4,5,6,7]
                    }]
                });

                $('input[name="start"], input[name="end"]').change(function () {
                    table.draw();
                });
            }

            $('body').on('click', '.player_block', function () {
                var pId = $(this).data('id');
                var pStatus = $(this).data('status');
                $.ajax({
                    url: '{{url(_ADMIN_PREFIX_URL."/players/status")}}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {'_token': $('meta[name="csrf-token"]').attr('content'), 'status': pStatus, 'pId': pId},
                    success: function (response) {
                        swal({
                            title: response.title,
                            html: response.message,
                            type: response.status,
                            allowOutsideClick: false
                        });
                        window.LaravelDataTables[tbladmin].draw(false);
                    },

                });
            })

            $('body').on('change', '#status', function () {
                window.LaravelDataTables[tbladmin].draw();
            })
        });
    </script>
    @include('backend.shared._deleteconfirm', [
    'entity' => 'players',
    'vid' => '$(this).data("id")'
    ])
    @endpush
