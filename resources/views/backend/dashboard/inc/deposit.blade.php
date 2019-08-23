<div class="m-portlet ">
    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-4">
                        <div class="m-widget24">
                            <div class="m-widget24__item">
                                <div class="row">
                                    <div class="col-5">
                                        <span class="m-widget24__desc">
                                            <i class="la la-bank la-size-130 text-primary"></i>
                                        </span>
                                    </div>
                                    <div class="col-7 col-total">
                                        <div>
                                            <h4 class="widget-title">
                                                {!! trans('labels.deposit_pending') !!}
                                            </h4>
                                            <span class="dboard-number">
                                                <a href="{{ url('/admin/deposittransactions') }}" class="text-primary"> {!! $tempTransaction->where('proc_type','deposit')->count() !!} Person(s) </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Total Profit-->
            </div>
            <div class="col-md-12 col-lg-6 col-xl-4">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <div class="row">
                                <div class="col-5">
                                    <span class="m-widget24__desc">
                                        <i class="la la-credit-card la-size-130 text-info"></i>
                                    </span>
                                </div>
                                <div class="col-7 col-total">
                                    <div>
                                        <h4 class="widget-title">
                                            {!! trans('labels.withdraw_pending') !!}
                                        </h4>
                                        <span class="dboard-number">
                                            <a href="{{ url('/admin/withdrawtransactions') }}" class="text-info"> {!! $tempTransaction->where('proc_type','WITHDRAW')->count() !!} Person(s)</a>
                                        </span>
                                    </div>

                                </div>
                            </div>


                        </div>

                    </div>

                    <!--end::Total Profit-->
        </div>
        <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="m-widget24">
                    <div class="m-widget24__item">
                        <div class="row">
                            <div class="col-5">
                                <span class="m-widget24__desc">
                                    <i class="la la-cc-diners-club la-size-130 text-success"></i>
                                </span>
                            </div>
                            <div class="col-7 col-total">
                                {{--  @php($process = Config('sysconfig.process'))  --}}
                                <div>
                                    <h4 class="widget-title">
                                        {!! trans('labels.tranfer_pending') !!}
                                    </h4>
                                    <span class="dboard-number">
                                        <a href="#" class="text-success"> 0 Person</a>
                                    </span>
                                </div>

                            </div>
                        </div>


                    </div>

                </div>

                <!--end::Total Profit-->
    </div>
        </div>
    </div>
</div>