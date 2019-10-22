@extends('backend.template.main')
@push('title',trans('menu.betlist'))

@section('content')
<div class="m-portlet m-portlet--last " >
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{trans('menu.betlist')}}
                </h3>
            </div>
        </div>   
        <div class="m-portlet__head-tools">

        </div>     
    </div>
    <div class="m-portlet__body">
        {!! $html->table(['class' => 'table table-striped table-bordered table-hover','id'=>'admin-tbl-zen']) !!}
    </div>

    <div class="modal fade" id="m_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Guess</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!!Form::open(['class' =>'m-form m-form--fit m-form--label-align-right','id' => 'frm-edit','method'=>'PATCH'])!!}

                    {!!Form::close()!!}

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('style')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" />
@endpush
@push('javascript')
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>

{!! $html->scripts() !!} 
<script>
var tbladmin = 'admin-tbl-zen';
$(document).ready(function () {
    $('<label  style="margin-left: 10px;">- Filter By: ' +
            '{!!Form::select("market",$marketGame,0,["class"=>"form-control form-control-sm","id" => "market"])!!}' +
            '{!!Form::select("cbogame",$game,0,["class"=>"form-control form-control-sm ml-1","id" => "game-ft"])!!} <input name="member_id" type="hidden" value="" id="member-filter">' +
            '</label>').appendTo("#admin-tbl-zen_length");
});
$('body').on('change', '#market', function () {
    window.LaravelDataTables[tbladmin].draw();
});
$('body').on('change', '#game-ft', function () {
    window.LaravelDataTables[tbladmin].draw();
});
$('body').on('click', '.modal-edit', function () {
    var Id = $(this).data('id');
    $.ajax({
        url: '{{url(_ADMIN_PREFIX_URL."/betlists")}}/' + Id,
        type: 'GET',
        dataType: 'json',

    }).done(function (response) {
        var betguess = response.betguess;
        var html = '@csrf <input name="_method" type="hidden" value="PATCH"><div class="form-group  row"><label for="cbo-market" class="col-2 col-form-label">Market:</label><div class="col-10">{!!Form::select("marketedit",$marketGame,0,["class"=>"form-control form-control-sm","id" => "cbo-market-edit"])!!}</div></div><div class="form-group  row"><label for="cbo-market" class="col-2 col-form-label">Game:</label><div class="col-10">{!!Form::select("cbogame-edit",$game,0,["class"=>"form-control form-control-sm ","id" => "game-edit","disabled" => true])!!}</div></div><div class="form-group  row"><label for="inputguess" class="col-2 col-form-label">Guess:</label><div class="col-10">{!!Form::text("inputguess","",["class"=>"form-control form-control-sm","id"=>"inputguess","disabled" => false])!!}</div></div><div class="form-group  row"><label class="col-2 col-form-label"></label><div class="col-10"><button class="btn btn-primary" id="save-guess">Save</button></div></div>';
        var notIn = [1, 2, 3, 4, 5];
        $('#frm-edit').attr('action', "{{url(_ADMIN_PREFIX_URL.'/betlists')}}/" + betguess.id);
        $('#frm-edit').html(html);
        $('#cbo-market-edit').val(betguess.market).change();
        $('#game-edit').val(betguess.gameId).change();
        $('#inputguess').attr('maxlength', betguess.guess.length);
        $('#inputguess').val(betguess.guess);
        if (!notIn.includes(parseInt(betguess.gameId))) {
         
            $('#inputguess').attr('disabled', true);
        }
        $('#m_modal').modal('show').on('hidden.bs.modal', function (e) {
            $('#frm-edit').html('');
        });
    }).fail(function () {
        swal('Oops...', 'Server Error please contact web master!', 'error');
    })
    $('body').on("keypress keyup blur", '#inputguess', function (event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
});
$('#frm-edit').submit(function (e) {
    $.ajax({
        url: $(this).attr('action'),
        type: 'POST',
        data: $(this).serialize(),
        success: function (data) {
            if (data.status)
                $('#m_modal').modal('hide');
            swal({
                title: 'Successfully',
                html: 'Guess has been updated !!!',
                type: 'success',
                allowOutsideClick: false
            });
            window.LaravelDataTables[tbladmin].draw();
        }
    });
    e.preventDefault();
});
$('body').on('click','.member-id',function(){
    var id = $(this).data('id');
    $('#member-filter').val(id).change();
    
});
$('#member-filter').change(function(){
    console.log('working')
})
</script>
@endpush