@extends('backend.template.main')
@push('title',trans('trans.Role Group'))
@section('content')
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    {{trans('trans.Role Group')}}
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
                <li class="m-portlet__nav-item">
                    <a href="#" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                        <span>
                            <i class="la la-plus"></i>
                            <span>New Record</span>
                        </span>
                    </a>
                </li>
            </ul>

        </div>

    </div>
    <div class="m-portlet__body">
        <!--begin: Datatable -->
        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_ajax">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>

    </div>
</div>
@endsection
@push('style')
<!--begin::Page Vendors Styles -->
<link href="{{asset('backend/assets/vendors/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
@endpush
@push('javascript')
<script src="{{asset('backend/assets/vendors/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
<script>
var DatatablesDataSourceAjaxServer = {
    init: function () {
        var e;
        (e = $("#m_table_ajax")).DataTable({
            responsive: !0, searchDelay: 500, processing: !0, serverSide: !0, ajax: "{{url(_ADMIN_PREFIX_URL.'/rolegroup')}}", 
            language: {
                lengthMenu: "Display _MENU_"
            },
            order: [[1, "desc"]], headerCallback: function (e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML = '\n<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">\n<input type="checkbox" value="" class="m-group-checkable">\n<span></span>\n</label>'
            },
            columns: [{data: 'id'}, {data: 'name'}, {data: 'status'}, {data: 'action'}],
            columnDefs: [{
                    targets: 0, width: "30px", className: "dt-right", orderable: !1, render: function (e, a, t, n) {
                        return'\n<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">\n <input type="checkbox" value="' + e + '" class="m-checkable">\n<span></span>\n</label>';
                    }
                }, {
                    targets: -1, title: "Actions", orderable: !1, render: function (e, a, t, n) {
                        return'\n <span class="dropdown">\n<a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">\n <i class="la la-ellipsis-h"></i>\n</a>\n<div class="dropdown-menu dropdown-menu-right">\n<a class="dropdown-item" href="#"><i class="la la-edit"></i> Edit Details</a>\n<a class="dropdown-item" href="#"><i class="la la-leaf"></i> Update Status</a>\n<a class="dropdown-item" href="#"><i class="la la-print"></i> Generate Report</a>\n</div>\n</span>\n<a href="#" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="View">\n<i class="la la-edit"></i>\n</a>'
                    }
                }]

        }), e.on("change", ".m-group-checkable", function () {
            var e = $(this).closest("table").find("td:first-child .m-checkable"), a = $(this).is(":checked");
            $(e).each(function () {
                a ? ($(this).prop("checked", !0), $(this).closest("tr").addClass("active")) : ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"));
            });
        }
        ),
                e.on("change", "tbody tr .m-checkbox", function () {
                    $(this).parents("tr").toggleClass("active");
                }
                );
    }
};
jQuery(document).ready(function () {
    DatatablesDataSourceAjaxServer.init()
});


</script>
@endpush