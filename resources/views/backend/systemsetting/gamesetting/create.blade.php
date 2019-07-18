@extends('backend.template.main')
@push('title',trans('menu.gamesetting').'-'.trans('trans.create'))
@section('content')
    {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/gamesettings/0'),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method' => 'PATCH'])!!}
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

        <div class="m-portlet__head" style="">
            <div class="m-portlet__head-wrapper">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{trans('menu.gamesetting').' / '.trans('trans.create')}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    {{--  @include('backend.shared._actionform')  --}}
                    <button type="button" name="btnsaveclose" id="btnsaveclose" class="btn btn-info m-btn m-btn--custom m-btn--icon m-btn--pill m-btn--air">
                        <span>
                            <i class="fa fa-archive"></i>
                            <span>{{__('trans.btnsave')}}</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <input type="hidden" id="id" name="id">
            <div class="form-group m-form__group row @if ($errors->has('market')) has-danger @endif">
                {!!Form::label('market', trans('labels.gamemarketname'),['class' => 'col-sm-2 col-form-label'])!!}
                <div class="col-sm-8">
                    <select class="form-control m-input" name="market" id="market_id">
                        @foreach($market as $item)
                            <option value="{{ $item->code }}">{{ $item->name }} - {{ $item->code }}</option>
                        @endforeach
                    </select>
                    {{--                                        {!!Form::select('market',$market,old('market'),['class'=>'form-control m-input'])!!}--}}
                    @if ($errors->has('market')) <p
                            class="form-control-feedback">{{ $errors->first('market') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('game')) has-danger @endif">
                {!!Form::label('game', trans('labels.gamename'),['class' => 'col-sm-2 col-form-label'])!!}
                <div class="col-sm-8">
                    <select class="form-control m-input" name="game" id="game_id">
                        @foreach($game as $item)
                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    {{--                    {!!Form::select('game',$game,old('game'),['class'=>'form-control m-input'])!!}--}}
                    @if ($errors->has('game')) <p
                            class="form-control-feedback">{{ $errors->first('game') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('discount')) has-danger @endif">
                {!!Form::label('discount', trans('labels.discount'),['class' => 'col-sm-2 col-form-label'])!!}
                <div class="col-sm-8">
                    <div class="input-group">
                        {!!Form::text('discount',old('discount'),['class' => 'form-control m-input','id'=>'discount'])!!}
                        <div class="input-group-append"><span class="input-group-text" id="basic-addon1">%</span></div>
                        @if ($errors->has('discount')) <p
                                class="form-control-feedback">{{ $errors->first('discount') }}</p> @endif
                    </div>
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('menang')) has-danger @endif">
                {!!Form::label('menang', trans('labels.win'),['class' => 'col-sm-2 col-form-label'])!!}
                <div class="col-sm-8">
                    {!!Form::text('menang',old('menang'),['class' => 'form-control m-input','id'=>'menang'])!!}
                    @if ($errors->has('menang')) <p
                            class="form-control-feedback">{{ $errors->first('menang') }}</p> @endif
                </div>
            </div>

            <div class="form-group m-form__group row @if ($errors->has('menang_dbl')) has-danger @endif">
                {!!Form::label('menang_dbl', trans('labels.doublewins'),['class' => 'col-sm-2 col-form-label'])!!}
                <div class="col-sm-8">
                    {!!Form::text('menang_dbl',old('menang_dbl'),['class' => 'form-control m-input','id'=>'menang_dbl'])!!}
                    @if ($errors->has('menang')) <p
                            class="form-control-feedback">{{ $errors->first('menang_dbl') }}</p> @endif
                </div>
            </div>

            <div class="form-group m-form__group row @if ($errors->has('menang_triple')) has-danger @endif">
                {!!Form::label('menang_triple', trans('labels.triplewins'),['class' => 'col-sm-2 col-form-label'])!!}
                <div class="col-sm-8">
                    {!!Form::text('menang_triple',old('menang_triple'),['class' => 'form-control m-input','id'=>'menang_triple'])!!}
                    @if ($errors->has('menang_triple')) <p
                            class="form-control-feedback">{{ $errors->first('menang_triple') }}</p> @endif
                </div>
            </div>

            <div class="form-group m-form__group row @if ($errors->has('menang_quadruple')) has-danger @endif">
                {!!Form::label('menang_quadruple', trans('labels.quadruplewins'),['class' => 'col-sm-2 col-form-label'])!!}
                <div class="col-sm-8">
                    {!!Form::text('menang_quadruple',old('menang_quadruple'),['class' => 'form-control m-input','id'=>'menang_quadruple'])!!}
                    @if ($errors->has('menang_quadruple')) <p
                            class="form-control-feedback">{{ $errors->first('menang_quadruple') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-9 font-size">
                    <span style="width: 133px;"><span class="m-badge m-badge--brand m-badge--wide">Note:</span></span>
                    <b>{{trans('labels.win')}}, {{trans('labels.doublewins')}}, {{trans('labels.triplewins')}}, {{trans('labels.quadruplewins')}}</b> if value is smaller than 2 means that
                    you want to charge as percentage.
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('kei')) has-danger @endif">
                {!!Form::label('kei', trans('labels.kei'),['class' => 'col-sm-2 col-form-label'])!!}
                <div class="col-sm-8">
                    {!!Form::text('kei',old('kei'),['class' => 'form-control m-input','id'=>'kei'])!!}
                    @if ($errors->has('kei')) <p
                            class="form-control-feedback">{{ $errors->first('kei') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-9 font-size">
                    <span style="width: 133px;"><span class="m-badge m-badge--brand m-badge--wide">Note:</span></span>
                    <b>{{ trans('labels.kei') }}</b> can be a discount value if you do not place - (Minus) before your value
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('min_bet')) has-danger @endif">
                {!!Form::label('min_bet', trans('labels.minimumbet'),['class' => 'col-sm-2 col-form-label'])!!}
                <div class="col-sm-8">
                    {!!Form::text('min_bet',old('min_bet'),['class' => 'form-control m-input','id'=>'min_bet'])!!}
                    @if ($errors->has('min_bet')) <p
                            class="form-control-feedback">{{ $errors->first('min_bet') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('max_bet')) has-danger @endif">
                {!!Form::label('max_bet', trans('labels.maximumbet'),['class' => 'col-sm-2 col-form-label'])!!}
                <div class="col-sm-8">
                    {!!Form::text('max_bet',old('max_bet'),['class' => 'form-control m-input','id'=>'max_bet'])!!}
                    @if ($errors->has('max_bet')) <p
                            class="form-control-feedback">{{ $errors->first('max_bet') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('bet_mod')) has-danger @endif">
                {!!Form::label('bet_mod', trans('labels.betmodulus'),['class' => 'col-sm-2 col-form-label'])!!}
                <div class="col-sm-8">
                    {!!Form::text('bet_mod',old('bet_mod'),['class' => 'form-control m-input','id'=>'bet_mod'])!!}
                    @if ($errors->has('bet_mod')) <p
                            class="form-control-feedback">{{ $errors->first('bet_mod') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-9 font-size">
                    <span style="width: 133px;"><span class="m-badge m-badge--brand m-badge--wide">Note:</span></span>
                    <b>{{ trans('labels.betmodulus') }}</b> is a amount which use to modulus with customer bet amount by the following
                    formula
                    <i>{bet_amount MOD bet_modulus}</i>
                    and return the remainder is Zero.
                </div>
            </div>
            <div class="form-group m-form__group row @if ($errors->has('bet_times')) has-danger @endif">
                {!!Form::label('bet_times', trans('labels.bettime'),['class' => 'col-sm-2 col-form-label'])!!}
                <div class="col-sm-8">
                    {!!Form::text('bet_times',old('bet_times'),['class' => 'form-control m-input','id'=>'bet_times'])!!}
                    @if ($errors->has('bet_times')) <p
                            class="form-control-feedback">{{ $errors->first('bet_times') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-9 font-size">
                    <span style="width: 133px;"><span class="m-badge m-badge--brand m-badge--wide">Note:</span></span>
                    <b> {{ trans('labels.limitbet')}}</b> is times of bet which use to limit customer bet times 0 for unlimited.
                </div>
            </div>
            {{--            <div class="form-group m-form__group row">--}}
            {{--                {!!Form::label('status','Active',['class' => 'col-sm-2 col-form-label'])!!}--}}
            {{--                <div class="col-sm-2">--}}
            {{--                    <input data-switch="true" type="checkbox" value="0" name="status" data-on-color="success"--}}
            {{--                           data-off-color="warning">--}}

            {{--                </div>--}}
            {{--            </div>--}}
        </div>

    </div>
    {!!Form::close()!!}
@endsection

@push('style')
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
@endpush
@push('javascript')


    {{--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>--}}

    <script type="text/javascript" src="{{ asset('backend/assets/jquery.furl.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('backend/assets/tagsinput/tagsinput.js')}}"></script>
    {{--{!!JsValidator::formRequest('App\Http\Requests\CategoriesRequest', '#idev-form')!!}--}}
    @include('backend.shared._selectimg',['selectElement' => '#banner'])
    @include('backend.shared._tinymce',['elements' => '.cms-editor'])
    <script type="text/javascript">
        var BootstrapSwitch = {
            init: function () {
                $("[data-switch=true]").bootstrapSwitch()
            }
        };
    

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
                    // idev-form.innerHTML = data;
                    // var test = $('#idev-form').html(data)
                    $('#discount').val(response[0].discount);
                    $('#menang').val(response[0].menang);
                    $('#menang_dbl').val(response[0].menang_dbl);
                    $('#menang_triple').val(response[0].menang_triple);
                    $('#menang_quadruple').val(response[0].menang_quadruple);
                    $('#kei').val(response[0].kei);
                    $('#min_bet').val(response[0].min_bet);
                    $('#max_bet').val(response[0].max_bet);
                    $('#bet_mod').val(response[0].bet_mod);
                    $('#bet_times').val(response[0].bet_times);
                    $('#id').val(response[0].id);
                }
            })
        }

        jQuery(document).ready(function () {
            BootstrapSwitch.init();
            getValue();
            $('#market_id').change(getValue);
            $('#game_id').change(getValue);
        });

        $(function(){
            $('body').on('click', '#btnsaveclose', function(){
                
                var discount = $('#discount').val();
                var menang = $('#menang').val();
                var menang_dbl = $('#menang_dbl').val();
                var menang_triple = $('#menang_triple').val();
                var menang_quadruple = $('#menang_quadruple').val();
                var kei = $('#kei').val();
                var min_bet = $('#min_bet').val();
                var max_bet =$('#max_bet').val();
                var bet_mod = $('#bet_mod').val();
                var bet_times = $('#bet_times').val();
                var id = $('#id').val();
                console.log(discount,menang,menang_dbl);
                $.ajax({
                    url: '{{url(_ADMIN_PREFIX_URL."/gamesettings/0")}}',
                    type: 'PATCH',
                    dataType: 'JSON',
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        discount,
                        menang,
                        menang_dbl,
                        menang_triple,
                        menang_quadruple,
                        kei,
                        min_bet,
                        max_bet,
                        bet_mod,
                        bet_times,
                        id
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
            })
        })
    </script>
@endpush