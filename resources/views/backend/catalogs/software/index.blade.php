@extends('backend.template.main')
@push('title',trans('menu.software'))
@section('content')
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile"  id="main_portlet">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{trans('menu.software')}}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                @include('backend.shared._actionbtn')
            </div>

        </div>
        <div class="m-portlet__body">
            {!! $html->table(['class' => 'table table-striped- table-bordered table-hover table-checkable','id'=>'admin-tbl-zen']) !!}
        </div>
    </div>
@endsection

@push('style')

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" />
@endpush
@push('javascript')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    {!! $html->scripts() !!}

    <script>
        var tbladmin = 'admin-tbl-zen';
    </script>
    @include('backend.shared._deleteconfirm', [
        'entity' => 'software',
        'vid' => '$(this).data("id")'
    ])

@endpush
