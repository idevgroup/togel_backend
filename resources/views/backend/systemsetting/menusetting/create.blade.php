@extends('backend.template.main') @push('title',trans('menu.frontmenu').'-'.trans('trans.create')) @section('content') {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/menusettings'),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true])!!}
<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

    <div class="m-portlet__head" style="">
        <div class="m-portlet__head-wrapper">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{trans('menu.frontmenu').' / '.trans('trans.create')}}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                @include('backend.shared._actionform')
            </div>
        </div>
    </div>
    <div class="m-portlet__body">

        <div class="form-group m-form__group row">
            {!!Form::label('parents',trans('labels.parents'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                {!!Form::select('parents',$get_parent,old('parents'),['class'=>'form-control m-input'])!!}
            </div>
        </div>
        <div class="form-group m-form__group row d-none">
            {!!Form::label('subparents',trans('labels.sub_parents'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                {!!Form::select('subparents',['No sub parent'],old('subparents'),['class'=>'form-control m-input','id' => 'subparents'])!!}
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('name')) has-danger @endif">
            {!!Form::label('name',trans('labels.name'),['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-7">
                {!!Form::text('name',old('name'),['class' => 'form-control m-input','id'=>'name'])!!} @if ($errors->has('name'))
                <p class="form-control-feedback">{{ $errors->first('name') }}</p> @endif
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('alias')) has-danger @endif">
            {!!Form::label('alias',trans('labels.alias'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                {!!Form::text('alias',old('alias'),['class' => 'form-control m-input','id' => 'alias' ])!!} @if ($errors->has('alias'))
                <p class="form-control-feedback">{{ $errors->first('alias') }}</p> @endif
            </div>
        </div>


        <div class="form-group m-form__group row">
            {!!Form::label('status',trans('labels.publish'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <input data-switch="true" type="checkbox" value="0" name="status" data-on-color="success" data-off-color="warning">

            </div>
        </div>

        <div class="form-group m-form__group row">
            {!!Form::label('type',trans('labels.type'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-2">
                        <label class="m-radio m-radio--state-success">
                            <input type="radio" name="type" value="1" {{( old('type') == 1)?'checked':'checked'}} > {!! trans('labels.home_page') !!}
                                   <span></span>
                        </label>
                    </div>
                    <div class="col-sm-2">
                        <label class="m-radio m-radio--state-primary">
                            <input type="radio" name="type" value="2" {{( old('type') == 2)?'checked':''}} > {!! trans('labels.custom_link') !!}
                                   <span></span>
                        </label>
                    </div>
                    <div class="col-sm-2">
                        <label class="m-radio m-radio--state-warning">
                            <input type="radio" name="type" value="3" {{( old('type') == 3)?'checked':''}} > {!! trans('labels.single_content') !!}
                                   <span></span>
                        </label>
                    </div>
                    <div class="col-sm-2 ">
                        <label class="m-radio m-radio--state-danger">
                            <input type="radio" name="type" value="4" {{( old('type') == 4)?'checked':''}} > {!! trans('labels.content_category') !!}
                                   <span></span>
                        </label>
                    </div>
                    <div class="col-sm-2 ">
                        <label class="m-radio m-radio--state-info">
                            <input type="radio" name="type" value="5" {{( old('type') == 5)?'checked':''}} > {!! trans('labels.single_product') !!}
                                   <span></span>
                        </label>
                    </div>
                    <div class="col-sm-2">
                        <label class="m-radio m-radio--state-success">
                            <input type="radio" name="type" value="6" {{( old('type') == 6)?'checked':''}} > {!! trans('labels.product_category') !!}
                                   <span></span>
                        </label>
                    </div>

                </div>
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('url')) has-danger @endif" id="sec_url" style="display: none;">
            {!!Form::label('url',trans('labels.url'),['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-7">
                {!!Form::text('url',old('url'),['class' => 'form-control m-input','id' => 'url' ])!!} @if ($errors->has('url'))
                <p class="form-control-feedback">{{ $errors->first('url') }}</p> @endif
            </div>
        </div>

        <div class="form-group m-form__group row @if ($errors->has('category_id')) has-danger @endif" id="sec_cat" style="display: none;">
            {!!Form::label('category_id',trans('labels.categoryname'),['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-7">
                {!!Form::select('category_id',$cateItems,old('category_id'),['class'=>'form-control m-input'])!!}
            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('text_cont')) has-danger @endif" id="sec_cont" style="display: none;">
            {!!Form::label('single_con',trans('labels.single_content'),['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-7">
                <input type="text" class="form-control m-input" name="single_con" id="single_con" value="{!! old('single_con') !!}" readonly>
                <input type="hidden" id="text_cont" name="text_cont" value="{!! old('text_cont') !!}">
                <a class="btn btn-default singleContent" 
                 name="singleContent" id="singleContent" style="position: absolute; top: 0px; right: 27px;">Choser Content</a>
                 @if ($errors->has('text_cont'))
                <p class="form-control-feedback">{{ $errors->first('text_cont') }}</p> @endif
            </div>
            <div class="col-sm-2 pl-0">

            </div>
        </div>
        <div class="form-group m-form__group row @if ($errors->has('text_product')) has-danger @endif" id="singleproduct" style="display: none;">
            {!!Form::label('single_con',trans('labels.single_product'),['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-7">
                <input type="text" class="form-control m-input" name="single_product" id="single_product" value="{!! old('single_product') !!}" readonly>
                <input type="hidden" id="text_product" name="text_product" value="{!! old('text_product') !!}">
                <a class="btn btn-default singleprodcut" 
                   name="singleproduct" id="singleproduct-selected" style="position: absolute; top: 0px; right: 27px;">Chooser Product</a>
                   @if ($errors->has('text_product'))
                <p class="form-control-feedback">{{ $errors->first('text_product') }}</p> @endif
            </div>
            <div class="col-sm-2 pl-0">

            </div>
        </div>
        <div class="form-group m-form__group row @if($errors->has('category_product')) has-danger @endif" id="category_product" style="display: none;">
            {!!Form::label('product_category',trans('labels.product_category'),['class' => 'col-sm-3 col-form-label required'])!!}
            <div class="col-sm-7">
                {!!Form::select('product_category',$cateProduct,old('product_category'),['class'=>'form-control m-input'])!!}
            </div>
        </div>
        <div class="form-group m-form__group row">
            {!!Form::label('newwindow',trans('labels.new_window'),['class' => 'col-sm-3 col-form-label'])!!}
            <div class="col-sm-7">
                <input data-switch="true" type="checkbox" value="0" name="newwindow" data-on-color="success" data-off-color="warning">

            </div>
        </div>
    </div>

</div>
{!!Form::close()!!} @endsection @push('style')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<style>
    .bootstrap-tagsinput .badge {
        margin: 2px 2px;
        padding: 5px 8px;
        font-size: 12px;
    }

    .bootstrap-tagsinput .badge [data-role="remove"] {
        margin-left: 10px;
        cursor: pointer;
        color: #99334a;
    }

    .bootstrap-tagsinput .badge [data-role="remove"]:after {
        content: "×";
        padding: 0px 4px;
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        font-size: 14px;
    }
</style>
@endpush @push('javascript')

<!--begin::Modal-->
<div class="modal fade" id="single-content" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{!! trans('labels.single_content') !!}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id='single-info'>
                <table class="table table-bordered" id="tableSingleContent">
                    <thead>
                        <tr>
                            <th>{!! trans('labels.image') !!}</th>
                            <th>{!! trans('labels.title') !!}</th>
<!--                            <th>{!! trans('labels.id') !!}</th>-->
                            <th>{!! trans('labels.category') !!}</th>
                            {{-- <th>{!! trans('labels.created') !!}</th> --}}
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="single-product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">{!! trans('labels.single_product') !!}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id='single-info'>
                <table class="table table-bordered" id="tableProductContent">
                    <thead>
                        <tr>
                            <th>{!! trans('labels.image') !!}</th>
                            <th>{!! trans('labels.title') !!}</th>
<!--                            <th>{!! trans('labels.id') !!}</th>-->
                            <th>{!! trans('labels.category') !!}</th>
                            {{-- <th>{!! trans('labels.created') !!}</th> --}}
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>


<!--end::Modal-->

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/select/1.3.0/js/dataTables.select.min.js"></script>


<script type="text/javascript">
var BootstrapSwitch = {
    init: function () {
        $("[data-switch=true]").bootstrapSwitch();
    }
};
$('#parents').change(function () {
    var parents = $('#parents').val();

    $.ajax({
        url: '{{ url(_ADMIN_PREFIX_URL."/menustting/create/getsubparent") }}',
        method: 'POST',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            parents
        },
        dataType: 'json',
        success: function (response) {
            var option = '<option value="">No parent</option>';
            $.each(response, function (k, v) {
                option += '<option value="' + k + '">' + v + '</option>';
            });
            $('#subparents').html(option);
            console.log(response);
        }
    })

})

$("body").delegate('.content_277', 'click', function () {
    var id = $(this).attr("data-id");
    var name = $(this).attr("data-name");
  
    $('#single-content').modal('hide')
    $('#single_con').val(name);
    $('#text_cont').val(id);
});

$("body").delegate('.content_273', 'click', function () {
    var id = $(this).attr("data-id");
    var name = $(this).attr("data-name");
    
    $('#single-product').modal('hide')
    $('#single_product').val(name);
    $('#text_product').val(id);
});
jQuery(document).ready(function () {
    BootstrapSwitch.init();
    linkinfo();
    $("body").delegate('.singleContent', 'click', function () {

        $('#single-content').modal('show').on('hidden.bs.modal', function (e) {
            $('#tableSingleContent tbody').remove();
        });
        getContent(277,'tableSingleContent');
    });
    
    $("body").delegate('.singleprodcut', 'click', function () {

        $('#single-product').modal('show').on('hidden.bs.modal', function (e) {
            $('#tableProductContent tbody').remove();
        });
        getContent(273,'tableProductContent');
    });
    
});
function getContent(cateId,tbl) {
    var table = $('#'+tbl).DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ url(Config::get("sysconfig.prefix")."/menusettings/catIdCon") }}',
            data: function (data) {
                data.catgory_parent = cateId;
            }
        },
        language: {
            paginate: {
                next: '<i class="la la-angle-right"></i>',
                previous: '<i class="la la-angle-left"></i>'
            }
        },
        columns: [{
                data: 'thumb',
                name: 'thumb',
                width: '50',
                height: '40'
            }, {
                data: 'name',
                name: 'name'
            }, {
                data: 'category_name',
                name: 'category_name'
            }
        ],
        bDestroy: true,
//        order: [
//            [3, 'DESC']
//        ],
    });
    $('select[name="catSingleCon"]').change(function () {
        var working = $('select[name="catSingleCon"]').val();
        table.draw();
    });
}


$("input[name='type']").click(function () {
    linkinfo()

});
function linkinfo() {
    var check_val = $("input:radio[name='type']:checked").val();
    if (check_val == '1') {
        $('#sec_url').hide();
        $("#sec_cont").hide();
        $("#sec_cat").hide();
        $('#singleproduct').hide();
        $('#category_product').hide();
    } else if (check_val == '2') {
        $('#sec_url').fadeIn();
        $("#sec_cont").hide();
        $("#sec_cat").hide();
        $('#singleproduct').hide();
        $('#category_product').hide();
    } else if (check_val == '3') {
        $('#sec_url').hide();
        $("#sec_cont").fadeIn();
        $("#sec_cat").hide();
        $('#singleproduct').hide();
        $('#category_product').hide();
    } else if (check_val == '4') {
        $('#sec_url').hide();
        $("#sec_cont").hide();
        $("#sec_cat").fadeIn();
        $('#singleproduct').hide();
        $('#category_product').hide();
    } else if (check_val == '5') {
        $('#sec_url').hide();
        $("#sec_cont").hide();
        $("#sec_cat").hide();
        $('#singleproduct').fadeIn();
        $('#category_product').hide();
    } else if (check_val == '6') {
        $('#sec_url').hide();
        $("#sec_cont").hide();
        $("#sec_cat").hide();
        $('#singleproduct').hide();
        $('#category_product').fadeIn();
    }
}
</script>
@endpush