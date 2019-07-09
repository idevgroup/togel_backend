@extends('backend.template.main')
@push('title',trans('menu.deposit'))
@section('content')
<div class="m-portlet m-portlet--last m-portlet--head-sm m-portlet--responsive-mobile" >
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{trans('menu.deposit')}}
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
@endpush
@push('javascript')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
{!! $dataTable->scripts() !!} 
<script>
$(function () {
    $("body").delegate('#btn-approval', 'click', function () {
        var transID = $(this).data('transid');
        var memberId = $(this).data('memberid');
        swal({
            title: 'Are you sure?',
            html: "Are yous sure wanted to process it?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, process it!',
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        url: '{{url(_ADMIN_PREFIX_URL."/deposittransactions")}}',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {transID, memberId, '_token': $('meta[name="csrf-token"]').attr('content')},
                        success: function (response) {
                            swal({
                                title: response.title,
                                html: response.message,
                                type: response.status,
                                allowOutsideClick: false
                            });
                            window.LaravelDataTables['admin-tbl-zen'].draw(false);
                        },
                    });
                });
            },
        })

    });
});
</script>

@endpush
