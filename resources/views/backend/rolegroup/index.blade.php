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
      
          {!! $html->table(['class' => 'table table-striped- table-bordered table-hover table-checkable']) !!}
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
@include('backend.shared._deleteconfirm', [
    'entity' => 'usergroup',
    'vid' => '$(this).data("id")'
])
<script>


</script>
@endpush