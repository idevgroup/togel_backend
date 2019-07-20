@extends('backend.template.main')
@push('title',trans('menu.bonusreferalssystem').'-'.trans('trans.create'))
@section('content') {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/bonusrefs/0'),
'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method' => 'PATCH'])!!}
<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

    <div class="m-portlet__head" style="">
        <div class="m-portlet__head-wrapper">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {!! trans('menu.bonusreferalssystem').' / '.trans('trans.create') !!}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
            </div>
        </div>
    </div>
    <div class="m-portlet__body">
        
        <div class="m-portlet m-portlet--tabs">
            <div class="m-portlet__head">
                <div class="m-portlet__head-tools">
                    <ul class="nav nav-tabs m-tabs-line m-tabs-line--danger m-tabs-line--2x m-tabs-line--right" role="tablist">
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link active" data-toggle="tab" href="#m_portlet_base_demo_2_1_tab_content" role="tab">
                                {!! trans('labels.bonus&referralssystem') !!}
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_base_demo_2_2_tab_content" role="tab">
                                {!! trans('labels.referraldepositbonus') !!}
                            </a>
                        </li>
                        <li class="nav-item m-tabs__item">
                            <a class="nav-link m-tabs__link" data-toggle="tab" href="#m_portlet_base_demo_2_3_tab_content" role="tab">
                                {!! trans('labels.referralbetbonus') !!}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body">
                <div class="tab-content">
                    <div class="tab-pane active" id="m_portlet_base_demo_2_1_tab_content" role="tabpanel">
                            <input type="hidden" name="regdep_id" id="regdep_id" value="{{ $regdep->id }}">
                            <div class="form-group m-form__group row @if ($errors->has('reg_bonus')) has-danger @endif">
                                <label class="col-sm-3 col-form-label">
                                    {!! trans('labels.registrationbonus') !!}
                                    <a href="#" data-toggle="m-tooltip"
                                       title="" data-html="true"
                                       data-original-title="{!! trans('labels.bonustoaddtouserwhentheyareregistertheiraccount.') !!}">[?]</a>
                                </label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        <!-- <div class="input-group-prepend">
                                            <button class="btn btn-secondary" type="button">Rp.</button>
                                        </div> -->
                                        {!!Form::text('reg_bonus',old('reg_bonus',$regdep->reg_bonus),['class' => 'form-control m-input','id'=>'reg_bonus'])!!}
                                        @if ($errors->has('reg_bonus'))
                                            <p class="form-control-feedback">{{ $errors->first('reg_bonus') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('dep_bonus')) has-danger @endif">
                                <label class="col-sm-3 col-form-label">
                                    {!! trans('labels.depositbonus') !!}
                                    <a href="#" data-toggle="m-tooltip"
                                       title="" data-html="true" data-original-title=" {!! trans('labels.bonustoaddtouserwhentheyaredeposited.') !!} ">[?]</a>
                                </label>
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        {!!Form::text('dep_bonus',old('dep_bonus',$regdep->dep_bonus),['class' => 'form-control m-input','id'=>'dep_bonus'])!!}
                                        <div class="input-group-append"><span class="input-group-text" id="basic-addon1">%</span></div>
                                        @if ($errors->has('dep_bonus'))
                                            <p class="form-control-feedback">{{ $errors->first('dep_bonus') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <button type="button" name="btnsaveclose" id="btnsavecloseregdep" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                                                <span>
                                                                    <i class="fa fa-archive"></i>
                                                                    <span>{{__('trans.btnsave')}}</span>
                                                                </span>
                                                            </button>
                                </div>
                            </div>
                    </div>
                    <div class="tab-pane" id="m_portlet_base_demo_2_2_tab_content" role="tabpanel">
                            <input type="hidden" name="refdep_id" id="refdep_id" value="{{ $refdep->id }}">
                            <div class="form-group m-form__group row @if ($errors->has('ref_dep1')) has-danger @endif">
                                {!!Form::label('ref_dep1', trans('labels.level1'),['class' => 'col-sm-3 col-form-label'])!!}
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        {!!Form::text('ref_dep1',old('ref_dep1', $refdep->ref_dep1),['class' => 'form-control m-input','id'=>'ref_dep1'])!!}
                                        <div class="input-group-append"><span class="input-group-text" id="basic-addon1">%</span></div>
                                        @if ($errors->has('ref_dep1'))
                                            <p class="form-control-feedback">{{ $errors->first('ref_dep1') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('ref_dep2')) has-danger @endif">
                                {!!Form::label('ref_dep2', trans('labels.level2'),['class' => 'col-sm-3 col-form-label'])!!}
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        {!!Form::text('ref_dep2',old('ref_dep2',$refdep->ref_dep2),['class' => 'form-control m-input','id'=>'ref_dep2'])!!}
                                        <div class="input-group-append"><span class="input-group-text" id="basic-addon1">%</span></div>
                                        @if ($errors->has('ref_dep2'))
                                            <p class="form-control-feedback">{{ $errors->first('ref_dep2') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('ref_dep3')) has-danger @endif">
                                {!!Form::label('ref_dep3',trans('labels.level3'),['class' => 'col-sm-3 col-form-label'])!!}
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        {!!Form::text('ref_dep3',old('ref_dep3',$refdep->ref_dep3),['class' => 'form-control m-input','id'=>'ref_dep3'])!!}
                                        <div class="input-group-append"><span class="input-group-text" id="basic-addon1">%</span></div>
                                        @if ($errors->has('ref_dep3'))
                                            <p class="form-control-feedback">{{ $errors->first('ref_dep3') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row @if ($errors->has('ref_dep4')) has-danger @endif">
                                {!!Form::label('ref_dep4',trans('labels.level4'),['class' => 'col-sm-3 col-form-label'])!!}
                                <div class="col-sm-7">
                                    <div class="input-group">
                                        {!!Form::text('ref_dep4',old('ref_dep4',$refdep->ref_dep4),['class' => 'form-control m-input','id'=>'ref_dep4'])!!}
                                        <div class="input-group-append"><span class="input-group-text" id="basic-addon1">%</span></div>
                                        @if ($errors->has('ref_dep4'))
                                            <p class="form-control-feedback">{{ $errors->first('ref_dep4') }}</p> @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <button type="button" name="btnsaveclose" id="btnsavecloseRefDep" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                                                <span>
                                                                    <i class="fa fa-archive"></i>
                                                                    <span>{{__('trans.btnsave')}}</span>
                                                                </span>
                                                            </button>
                                </div>
                            </div>
                    </div>
                    <div class="tab-pane" id="m_portlet_base_demo_2_3_tab_content" role="tabpanel">
                    <input type="hidden" id="game_setting_id" name="game_setting_id">
                        <div class="form-group m-form__group row @if ($errors->has('market')) has-danger @endif">
                            {!!Form::label('market', trans('labels.gamemarketname'),['class' => 'col-sm-3 col-form-label'])!!}
                            <div class="col-sm-7">
                                <select class="form-control m-input" name="market" id="market_id">
                                    @foreach($market as $item)
                                        <option value="{{ $item->code }}">{{ $item->name }} - {{ $item->code }}</option>
                                    @endforeach
                                </select> @if ($errors->has('market'))
                                    <p class="form-control-feedback">{{ $errors->first('market') }}</p> @endif
                            </div>
                        </div>
                        <div class="form-group m-form__group row @if ($errors->has('game')) has-danger @endif">
                            {!!Form::label('game', trans('labels.gamename'),['class' => 'col-sm-3 col-form-label'])!!}
                            <div class="col-sm-7">
                                <select class="form-control m-input" name="game" id="game_id">
                                    @foreach($game as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select> @if ($errors->has('game'))
                                    <p class="form-control-feedback">{{ $errors->first('game') }}</p> @endif
                            </div>
                        </div>

                        <div class="form-group m-form__group row @if ($errors->has('ref_bet1')) has-danger @endif">
                            {!!Form::label('ref_bet1', trans('labels.level1'),['class' => 'col-sm-3 col-form-label'])!!}
                            <div class="col-sm-7">
                                <div class="input-group">
                                    {!!Form::text('ref_bet1',old('ref_bet1'),['class' => 'form-control m-input','id'=>'ref_bet1'])!!}
                                    <div class="input-group-append"><span class="input-group-text" id="basic-addon1">%</span></div>
                                    @if ($errors->has('ref_bet1'))
                                        <p class="form-control-feedback">{{ $errors->first('ref_bet1') }}</p> @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row @if ($errors->has('ref_bet2')) has-danger @endif">
                            {!!Form::label('ref_bet2', trans('labels.level2'),['class' => 'col-sm-3 col-form-label'])!!}
                            <div class="col-sm-7">
                                <div class="input-group">
                                    {!!Form::text('ref_bet2',old('ref_bet2'),['class' => 'form-control m-input','id'=>'ref_bet2'])!!}
                                    <div class="input-group-append"><span class="input-group-text" id="basic-addon1">%</span></div>
                                    @if ($errors->has('ref_bet2'))
                                        <p class="form-control-feedback">{{ $errors->first('ref_bet2') }}</p> @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row @if ($errors->has('ref_bet3')) has-danger @endif">
                            {!!Form::label('ref_bet3', trans('labels.level3'),['class' => 'col-sm-3 col-form-label'])!!}
                            <div class="col-sm-7">
                                <div class="input-group">
                                    {!!Form::text('ref_bet3',old('ref_bet3'),['class' => 'form-control m-input','id'=>'ref_bet3'])!!}
                                    <div class="input-group-append"><span class="input-group-text" id="basic-addon1">%</span></div>
                                    @if ($errors->has('ref_bet3'))
                                        <p class="form-control-feedback">{{ $errors->first('ref_bet3') }}</p> @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row @if ($errors->has('ref_bet4')) has-danger @endif">
                            {!!Form::label('ref_bet4', trans('labels.level4'),['class' => 'col-sm-3 col-form-label'])!!}
                            <div class="col-sm-7">
                                <div class="input-group">
                                    {!!Form::text('ref_bet4',old('ref_bet4'),['class' => 'form-control m-input','id'=>'ref_bet4'])!!}
                                    <div class="input-group-append"><span class="input-group-text" id="basic-addon1">%</span></div>
                                    @if ($errors->has('ref_bet4'))
                                        <p class="form-control-feedback">{{ $errors->first('ref_bet4') }}</p> @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group m-form__group row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9">
                                    <button type="button" name="btnsaveclose" id="btnsavecloseRefbet" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                                                                <span>
                                                                    <i class="fa fa-archive"></i>
                                                                    <span>{{__('trans.btnsave')}}</span>
                                                                </span>
                                                            </button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
{!!Form::close()!!} @endsection @push('style')
    <link rel="stylesheet" href="{{asset('backend/assets/fileinput/fileinput.css')}}"/>
    <link rel="stylesheet" href="{{asset('backend/assets/tagsinput/tagsinput.css')}}"/>
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

        .font-size {
            font-size: 11px;
        }
    </style>
@endpush @push('javascript') {{--


<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>--}}

<script type="text/javascript" src="{{ asset('backend/assets/jquery.furl.js')}}"></script>
<script type="text/javascript" charset="utf8" src="{{asset('backend/assets/tagsinput/tagsinput.js')}}"></script>
{{--{!!JsValidator::formRequest('App\Http\Requests\CategoriesRequest', '#idev-form')!!}--}} @include('backend.shared._selectimg',['selectElement' => '#banner']) @include('backend.shared._tinymce',['elements' => '.cms-editor'])
<script type="text/javascript">
    $('#name').furl({
        id: 'slug',
        seperate: '-'
    });
    var BootstrapSwitch = {
        init: function () {
            $("[data-switch=true]").bootstrapSwitch()
        }
    };
    $(function () {
        getValue();
        $('#market_id').change(getValue);
        $('#game_id').change(getValue);
    })

    function getValue() {
        var market = $("#market_id").val();
        var game = $('#game_id').val();
        $.ajax({
            url: '{{ url(_ADMIN_PREFIX_URL."/gameSettingVal") }}',
            method: 'POST',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                market: market,
                game: game
            },
            dataType: 'json',
            success: function (response) {
                $('#discount').val(response[0].discount);
                $('#ref_bet1').val(response[0].ref_bet_1);
                $('#ref_bet2').val(response[0].ref_bet_2);
                $('#ref_bet3').val(response[0].ref_bet_3);
                $('#ref_bet4').val(response[0].ref_bet_4);
                // $('#menang_quadruple').val(response[0].menang_quadruple);
                // $('#kei').val(response[0].kei);
                // $('#min_bet').val(response[0].min_bet);
                // $('#max_bet').val(response[0].max_bet);
                // $('#bet_mod').val(response[0].bet_mod);
                // $('#bet_times').val(response[0].bet_times);
                $('#game_setting_id').val(response[0].id);

                // console.log(response[0]);
            }
        })
    }

    jQuery(document).ready(function () {
        BootstrapSwitch.init();

        /*
        function createCounter() {
            var counter = 0;
          return ++counter;
        }
        const test = createCounter();

        console.log(test);
        */
    });
    $(function(){
        //Bonus & Refferrals System
        $('body').on('click', '#btnsavecloseregdep', function() {
                var regdep_id = $('#regdep_id').val();
                var reg_bonus = $('#reg_bonus').val();
                var dep_bonus = $('#dep_bonus').val();
                $.ajax({
                    url: '{{url(_ADMIN_PREFIX_URL."/bonusrefs/0")}}',
                    type: 'PATCH',
                    dataType: 'JSON',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        reg_bonus,
                        dep_bonus,
                        regdep_id
                    },
                    success: function(response) {
                        swal({
                            title: response.title,
                            html: response.message,
                            type: response.status,
                            allowOutsideClick: false,
                            timer: 1500
                        });
                    }
                })
            });

            //Referral Deposit Bonus
            $('body').on('click', '#btnsavecloseRefDep', function(){

                var refdep_id = $('#refdep_id').val();
                var ref_dep1 = $('#ref_dep1').val();
                var ref_dep2 = $('#ref_dep2').val();
                var ref_dep3 = $('#ref_dep3').val();
                var ref_dep4 = $('#ref_dep4').val();
                $.ajax({
                    url: '{{ url(_ADMIN_PREFIX_URL."/bonusrefs/0") }}',
                    method: 'PATCH',
                    dataType: 'JSON',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        refdep_id,
                        ref_dep1,
                        ref_dep2,
                        ref_dep3,
                        ref_dep4
                    },
                    success: function(res){
                        swal({
                            title: res.title,
                            html: res.message,
                            type: res.status,
                            allowOutsideClick: false,
                            timer: 1500
                        });
                    }
                })
            })

            //Referral Deposit Bonus
            $('body').on('click', '#btnsavecloseRefbet', function(){

            var refbet_id = $('#game_setting_id').val();
            var ref_bet1 = $('#ref_bet1').val();
            var ref_bet2 = $('#ref_bet2').val();
            var ref_bet3 = $('#ref_bet3').val();
            var ref_bet4 = $('#ref_bet4').val();
            // console.log(refdep_id);
            $.ajax({
                url: '{{ url(_ADMIN_PREFIX_URL."/bonusrefs/0") }}',
                method: 'PATCH',
                dataType: 'JSON',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    refbet_id,
                    ref_bet1,
                    ref_bet2,
                    ref_bet3,
                    ref_bet4
                },
                success: function(res){
                    swal({
                        title: res.title,
                        html: res.message,
                        type: res.status,
                        allowOutsideClick: false,
                        timer: 1500
                    });
                }
            })
            })
    });
</script>
@endpush
