@extends('backend.template.main')
@push('title',trans('menu.notification').'-'.trans('trans.create'))
@section('content')
    {!!Form::open(['url' =>url(_ADMIN_PREFIX_URL.'/notifications/'.$notification->id),'class' =>' m-form--state m-form m-form--fit m-form--label-align-right','id'=>'idev-form','files'=>true,'method' => 'PATCH'])!!}
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" id="main_portlet">

        <div class="m-portlet__head" style="">
            <div class="m-portlet__head-wrapper">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            {{trans('trans.edit') .' '.trans('menu.notification')}}
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    @include('backend.systemsetting.notification.inc._actionform')
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="form-group m-form__group row">
                {!! Form::label('nt_name', trans('labels.notification_name'), ['class' => 'col-sm-3 col-form-label required']) !!}
                <div class="col-sm-5">
                    {!! Form::text('nt_name', old('nt_name', $notification->nt_name), ['class' => 'form-control m-input','id'=>'nt_name']) !!}
                    @if ($errors->has('ip')) <p class="form-control-feedback">{{ $errors->first('ip') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row @if($errors->has('sound')) has-danger @endif">
                {!!Form::label('sound',trans('labels.image'),['class' => 'col-sm-3 col-form-label'])!!}
                <div class="col-sm-5">
                    {!!Form::file('sound',['id' =>'sound'])!!}
                        @if ($errors->has('sound')) <p class="form-control-feedback">{{ $errors->first('sound') }}</p> @endif
                </div>
            </div>
            <div class="form-group m-form__group row @if($errors->has('sound')) has-danger @endif">
                <div class="col-sm-3 col-form-label"></div>
                <div class="col-sm-5">
                    <audio controls>
                        <source src="{!! asset('uploads/audio/'. $notification->nt_sound) !!}" type="audio/wav" id="sound2">
                    </audio>
                </div>
            </div>
            {{--  <div class="12">
                    <audio controls>
                        <source src="{!! asset('audio/register.wav') !!}" type="audio/wav">
                    </audio>
                </div>  --}}
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
    </style>
@endpush
@push('javascript')


    {{--<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js')}}"></script>--}}

    <script type="text/javascript" src="{{ asset('backend/assets/jquery.furl.js')}}"></script>
    <script type="text/javascript" charset="utf8" src="{{asset('backend/assets/tagsinput/tagsinput.js')}}"></script>
    <!--begin::Page Scripts -->
    <script src="{{ asset('backend/assets/demo/default/custom/crud/forms/widgets/bootstrap-timepicker.js') }}"
            type="text/javascript"></script>
    {{--{!!JsValidator::formRequest('App\Http\Requests\CategoriesRequest', '#idev-form')!!}--}}
    @include('backend.shared._selectimg',['selectElement' => '#banner'])
    @include('backend.shared._tinymce',['elements' => '.cms-editor'])
    <script type="text/javascript">
        $('#name').furl({id: 'slug', seperate: '-'});
        var BootstrapSwitch = {
            init: function () {
                $("[data-switch=true]").bootstrapSwitch()
            }
        };

        $('#sound').on("change", function(){
            var s = $(this).val();
            
           
            if(s.indexOf("mp3")!==-1||s.indexOf("wav")!==-1||s.indexOf("ogg")!==-1){
                var c=(this.files[0].size/1024);
                console.log(s);
                $('#btnsaveclose').removeAttr("disabled");
                $('#btnsaverefresh').removeAttr("disabled");
            }
            {{--  messsages("Error","Only Mp3, Wav and Ogg file type are allowed!")  --}}
        })

        jQuery(document).ready(function () {
            BootstrapSwitch.init()
            {{--  var sound = $('#sound').val();
            console.log(sound);  --}}
          

            $('#sound').ace_file_input('show_file_list', [{
                type: 'image',
                name: '{{asset($notification->nt_sound)}}'
            }]);

            //validation
            var ip = $("#ip").val();
            $("#ip").keyup(function() {
                var $this = $(this);
                $this.val($this.val().replace(/[^\d.]/g, ''));
                if(ip == '0.0.0.0')  {
                    console.log('working');
                }      
            });



        });
    </script>
@endpush