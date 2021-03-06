<div class="m-portlet ">
    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-md-12 col-lg-6 col-xl-4">
                <div class="m-widget24">
                    <div class="m-widget24__item">

                        <div class="row">
                            <div class="col-4">
                                <span class="m-widget24__desc">
                                    <i class="la la-group la-size-130 text-primary"></i>
                                </span>

                            </div>
                            <div class="col-4 col-total">
                                <div>
                                    <h4 class="widget-title">
                                        {!! trans('labels.newregister') !!}
                                    </h4>
                                    <span class="dboard-number text-primary">
                                        {!! $playerReg->count(); !!} Person(s)                             
                                    </span>    
                                </div> 

                            </div>
                            <div class="col-4 col-total">
                                <div>
                                    <h4 class="widget-title">
                                        {!! trans('labels.customers') !!}
                                    </h4>
                                    <span class="dboard-number text-primary">
                                        {!! $player->count('id'); !!} Person
                                    </span>    
                                </div> 

                            </div>
                          
                        </div>


                    </div>

                </div>

                <!--end::Total Profit-->
            </div>
            <div class="col-md-12 col-lg-6 col-xl-4">

                <!--begin::New Feedbacks-->
                <div class="m-widget24">
                    <div class="m-widget24__item">

                        <div class="row">
                            <div class="col-5">
                                <span class="m-widget24__desc">
                                    <i class="la la-money la-size-130 text-info"></i>
                                </span>

                            </div>
                            <div class="col-7 col-total">
                                <div>
                                    <h4 class="widget-title">
                                        {!! trans('labels.customers_balance') !!}
                                    </h4>
                                    <span class="dboard-number text-info">
                                       {{--  {!! CommonFunction::_CurrencyFormat($player->sum('reg_remain_balance')) !!}  --}}
                                       {!! CommonFunction::_CurrencyFormat($player->where('reg_remain_balance', '>=', 0)->sum('reg_remain_balance')) !!}
                                    </span>    
                                </div> 

                            </div>
                        </div>


                    </div>
                </div>

                <!--end::New Feedbacks-->
            </div>
            <div class="col-md-12 col-lg-6 col-xl-4">

                <!--begin::New Orders-->
                <div class="m-widget24">
                     <div class="m-widget24__item">

                        <div class="row">
                            <div class="col-6">
                                <span class="m-widget24__desc">
                                   <i class="la la-pie-chart la-size-130 text-success"></i>
                                </span>

                            </div>
                            <div class="col-6 col-total">
                                <div>
                                    <h4 class="widget-title">
                                        {!! trans('labels.profit') !!}
                                    </h4>
                                    <span class="dboard-number text-success">
                                         {{CommonFunction::_CurrencyFormat(254)}}
                                    </span>    
                                </div> 

                            </div>
                        </div>


                    </div>
                </div>

                <!--end::New Orders-->
            </div>
        </div>
    </div>
</div>