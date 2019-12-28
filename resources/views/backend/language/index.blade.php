@extends('backend.template.main')
@push('title',trans('menu.language'))
@section('content')
    <div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile" >
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{trans('menu.language')}}
                    </h3>
                </div>
            </div>
            <div class="m-portlet__head-tools">
                <a href="{{url(Config::get('sysconfig.prefix').'/translations-setup')}}" target="_blank" class="btn btn-success">Language Setup</a>
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="table table-striped- table-bordered table-hover table-checkable dataTable no-footer dtr-inline">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Language</th>
                       
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($language as $row)
                    <tr>
                        <td>{{$loop->index + 1}}</td>
                        <td><span class="flag-icon {{$row->class}}"> </span> {{$row->name}}-({{$row->code}})</td>
                        <td id="id_{{$row->id}}">{!!_CheckStatus($row->status,$row->id)!!}</td>
                    </tr>
                    @endforeach
                </tbody>    
            </table>
        </div>
    </div>
@endsection

@push('style')

    <link rel="stylesheet" href="{{asset('backend/assets/lang/css/flag-icon.min.css')}}" />
@endpush
@push('javascript')
 
 <script>
      $("body").delegate('.published', 'click', function (e) {
        var status = $(this).data('status');
        var id = $(this).data('id');
        $.ajax({
            url: "{{url(Config::get('sysconfig.prefix').'/languages')}}/status",
            type: 'POST',
            dataType: 'JSON',
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'status': status,
                'id': id
            },
            success: function (data) {
                if (data.status === 0) {
                    notifytype = 'danger';
                    notifyicon = 'la la-warning';
                    notifytitle = "{{trans('trans.unpublishedbtn')}}";
                } else if (data.status === 1) {
                    notifytype = 'success';
                    notifyicon = 'la la-info-circle';
                    notifytitle = "{{trans('trans.publishedbtn')}}";
                }
                $.notify({
                    title: notifytitle,
                    icon:'icon ' + notifyicon,
                    message: data.message
                }, {
                    type: notifytype
                });
                $('#id_' + data.id).html(data.html);
            }
        });
    });

     </script>
    
 @endpush   