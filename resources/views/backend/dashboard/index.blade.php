@extends('backend.template.main') @section('content')

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="row">
        <div class="col-xl-12">
            @include('backend.dashboard.inc.total')
        </div>
    </div>
    <div class="row">
        <!-- Start Register Awaiting Process -->
        @include('backend.dashboard.inc.register')
        <!-- End Register Awaiting Process -->
        <!-- start Transfer -->
        @include('backend.dashboard.inc.transfer')
        <!-- End Transfer -->

        <!-- start Deposit -->
        @include('backend.dashboard.inc.deposit')
        <!-- End Deposit -->

        <!-- start Withdraw -->
        @include('backend.dashboard.inc.withdraw')
        <!-- End Withdraw -->
    </div>
    <div class="row">
        <div class="col-xl-12">
            @include('backend.dashboard.inc.bankReport')
        </div>
    </div>
</div>


@endsection @push('javascript')

<!--begin::Page Scripts -->
<script src="{{asset('backend/assets/app/js/dashboard.js')}}" type="text/javascript"></script>

<!--begin::Page Vendors -->
<script src="{{asset('backend/assets/vendors/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>

<!--end::Page Vendors -->
<!--begin::Page Scripts -->
<script src="{{asset('backend/assets/demo/default/custom/crud/datatables/search-options/advanced-search.js')}}" type="text/javascript"></script>

<!--end::Page Scripts -->
@endpush