<div class="m-portlet ">
    <div class="m-portlet__body  m-portlet__body--no-padding">
        <div class="row m-row--no-padding m-row--col-separator-xl">
            <div class="col-md-12 col-lg-12 col-xl-6">
                <div class="m-widget24">
                    <div class="m-widget24__item">
                        <div class="row">
                            <div class="col-12 col-sm-3 col-lg-3">
                                <span class="m-widget24__desc">
                                    <i class="la la-bank la-size-130 text-primary"></i>
                                </span>
                            </div>
                            @php($process = Config('sysconfig.process'))
                            <div class="col-12 col-sm-9 col-lg-9">
                                    <div class="row">
                                            @foreach ($process as $key => $value)
                                            {{--  @foreach ($tempTransaction as $item)  --}}
                                                @if ($key == 0)
                                                    <div class="col-sm-12 col-md-4 col-total">
                                                        <div>
                                                            <h4 class="widget-title">
                                                                {!! trans('labels.deposit_pending') !!}
                                                            </h4>
                                                            <span class="dboard-number">
                                                                    <a href="{{ url('/admin/deposittransactions') }}" class="text-primary"> {!! $tempTransaction->where('proc_type','deposit')->where('status',0)->count() !!} Person(s) </a>
                                                                </span>
                                                        </div>
                                                    </div>
                                                @elseif($key == 1)
                                                    <div class="col-sm-12 col-md-4 col-total">
                                                            <div>
                                                                <h4 class="widget-title">
                                                                    {{--  {!! trans('labels.deposit_pending') !!}  --}}
                                                                    Approval
                                                                </h4>
                                                                <span class="dboard-number">
                                                                        <a href="{{ url('/admin/deposittransactions') }}" class="text-primary"> {!! $tempTransaction->where('proc_type','deposit')->where('status',1)->count() !!} Person(s) </a>
                                                                    </span>
                                                            </div>
                                                        </div>
                                                        @elseif($key == 2)
                                                        <div class="col-sm-12 col-md-4 col-total">
                                                                <div>
                                                                    <h4 class="widget-title">
                                                                        {{--  {!! trans('labels.deposit_pending') !!}  --}}
                                                                        Reject
                                                                    </h4>
                                                                    <span class="dboard-number">
                                                                            <a href="{{ url('/admin/deposittransactions') }}" class="text-primary">
                                                                                {!! $tempTransaction->where('proc_type','deposit')->where('status',2)->count() !!} Person(s) 
                                                                            </a>
                                                                        </span>
                                                                </div>
                                                            </div>
                                                @endif 
                                            {{--  @endforeach  --}}
                                        @endforeach
                                    </div>
                            </div>
                         
                        </div>
                    </div>
                </div>
                <!--end::Total Profit-->
            </div>
            <div class="col-md-12 col-lg-12 col-xl-6">
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <div class="row">
                                <div class="col-12 col-sm-3 col-lg-3">
                                    <span class="m-widget24__desc">
                                        <i class="la la-credit-card la-size-130 text-success"></i>
                                    </span>
                                </div>
                                @php($process = Config('sysconfig.process'))
                                <div class="col-12 col-sm-9 col-lg-9">
                                        <div class="row">
                                                @foreach ($process as $key => $value)
                                                {{--  @foreach ($tempTransaction as $item)  --}}
                                                    @if ($key == 0)
                                                        <div class="col-sm-12 col-md-4 col-total">
                                                            <div>
                                                                <h4 class="widget-title">
                                                                    {!! trans('labels.withdraw_pending') !!}
                                                                </h4>
                                                                <span class="dboard-number">
                                                                        <a href="{{ url('/admin/deposittransactions') }}" class="text-success"> {!! $tempTransaction->where('proc_type','WITHDRAW')->where('status',0)->count() !!} Person(s) </a>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    @elseif($key == 1)
                                                        <div class="col-sm-12 col-md-4 col-total">
                                                                <div>
                                                                    <h4 class="widget-title">
                                                                        {{--  {!! trans('labels.deposit_pending') !!}  --}}
                                                                        Approval
                                                                    </h4>
                                                                    <span class="dboard-number">
                                                                            <a href="{{ url('/admin/deposittransactions') }}" class="text-success"> {!! $tempTransaction->where('proc_type','WITHDRAW')->where('status',1)->count() !!} Person(s) </a>
                                                                        </span>
                                                                </div>
                                                            </div>
                                                            @elseif($key == 2)
                                                            <div class="col-sm-12 col-md-4 col-total">
                                                                    <div>
                                                                        <h4 class="widget-title">
                                                                            {{--  {!! trans('labels.deposit_pending') !!}  --}}
                                                                            Reject
                                                                        </h4>
                                                                        <span class="dboard-number">
                                                                                <a href="{{ url('/admin/deposittransactions') }}" class="text-success">
                                                                                    {!! $tempTransaction->where('proc_type','WITHDRAW')->where('status',2)->count() !!} Person(s) 
                                                                                </a>
                                                                            </span>
                                                                    </div>
                                                                </div>
                                                    @endif 
                                                {{--  @endforeach  --}}
                                            @endforeach
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