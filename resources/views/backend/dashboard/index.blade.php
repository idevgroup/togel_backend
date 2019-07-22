@extends('backend.template.main') @section('content')

<div class="m-grid__item m-grid__item--fluid m-wrapper">
    <div class="row">
        <div class="col-xl-12">
            @include('backend.dashboard.inc.total')

            <!-- start Deposit -->
            @include('backend.dashboard.inc.deposit')
            <!-- End Deposit -->
        </div>
    </div>
    {{--  <div class="row">
        <!-- start Withdraw -->
        @include('backend.dashboard.inc.withdraw')
        <!-- End Withdraw -->
          <!-- start Transfer -->
        @include('backend.dashboard.inc.transfer')
        <!-- End Transfer -->

    </div>  --}}
   {{-- <div class="row">
        <div class="col-xl-12">
            @include('backend.dashboard.inc.bankReport')
        </div>
    </div>--}}
</div>


@endsection 
@push('style')
<style>
    .dboard-number{
        font-size: 25px !important;
        font-weight: 600;
    }
    .dboard-number a{
        text-decoration: none;
    }
    .widget-title{
        text-align: center;
        margin-top: 10px;
        font-size: 22px;
    }
    .col-total{
        text-align: center;
        display: table;
        
    }
    .col-total div{
        display: table-cell;
        vertical-align: middle;
        position: relative;
        top: 20%;
    }
    .la.la-size-130{
        font-size: 130px;
    }
</style>
@endpush
@push('javascript')

@endpush