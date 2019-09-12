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
            <button type="button" id="modal-result" class="btn m-btn--pill m-btn--air  btn-primary m-btn--wide" >Add Result</button>
        </div>
    </div>
    <div class="m-portlet__body">
        {!! $html->table(['class' => 'table table-striped table-bordered table-hover','id'=>'admin-tbl-zen']) !!}
    </div>
    <div class="modal fade" id="m_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Game Result</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                     {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/result4ds'),'class' =>'m-form m-form--fit m-form--label-align-right','id' => 'html-form'])!!}
                     
                    {!!Form::close()!!}
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
        var market = {!! json_encode($marketGame)!!}
$(document).ready(function () {
    $('<label  style="margin-left: 10px;">- Filter By: ' +
            '{!!Form::select("market",$marketGame,0,["class"=>"form-control form-control-sm","id" => "market"])!!}' +
            '</label>').appendTo("#admin-tbl-zen_length");
});
$('body').on('change', '#market', function () {
    window.LaravelDataTables[tbladmin].draw();
})
$('body').on('click', '#modal-result', function () {
    var html = '@csrf <div class="form-group" >	<label>Market: </label><select class="form-control m-input m-input--square" id="cbo-market" name="cbomarket" >';
    $.each(market, function (key, value) {
        html += '<option value="' + key + '">' + value + '</option>';
    });
    html += '</select> </div><div class="form-group"><label>Period: </label>' +
            '<input type="text" readonly class="form-control m-input m-input--square" id="market-period" name="txtperiod"></div>';
    html += '<div class="form-group"><label >Result: </label>' +
            '<input type="text" class="form-control m-input m-input--square" id="market-result" maxlength="4" name="txtresult"></div>';
    html += '<div class="form-group"><label >Result Date: </label>' +
            '<input type="text" readonly class="form-control m-input m-input--square" value="{{date("Y-m-d")}}" id="market-date" name="txtdate" ></div> <div class="form-group">  <button type="submit" class="btn btn-primary" >Submit</button> <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a></div>';
    $('#html-form').html(html);
    $('#m_modal').modal('show');
})

$('body').on('change', '#cbo-market', function () {
    $.ajax({
        url: '{{url(_ADMIN_PREFIX_URL."/result4ds/getperiod")}}',
        type: 'POST',
        dataType: 'JSON',
        data: {'_token': $('meta[name="csrf-token"]').attr('content'), marketcode: $(this).val()},
        success: function (response) {
            $('#market-period').val(response.period)
        }
    });
})
</script>

@endpush
