@extends('backend.template.main')
@push('title',trans('menu.rolepermission'))
@section('content')

<div class="m-portlet m-portlet--last m-portlet--head-lg m-portlet--responsive-mobile"  id="main_portlet">

    <div class="m-portlet__head m-form">
        <div class="col-lg-6" style="padding-top: 25px;">


            <div class="row ">
                {!! Form::label('roles',  trans('menu.rolepermission'),['class' => 'col-3 col-form-label required']) !!}
                <div class="col-6">
                    {!! Form::select('roles', $roles, old('roles'),  ['class' => 'form-control m-input']) !!}
                </div>
            </div>


        </div>
        <div class="m-portlet__head-tools">
            <button class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" id="submitPermission">
                {{__('trans.btnapply')}}
            </button>
        </div>

    </div>
    <div class="m-portlet__body" id="panel-permissions">

    </div>

</div>
@endsection
@push('javascript')
<script type="text/javascript">
    $(document.body).on('change', '#roles', function () {
        var id = $(this).val();
        $.ajax({
            url: "{{url(Config::get('sysconfig.prefix').'/rolepermissions')}}/" + id,
            type: 'GET',
            dataType: 'JSON',
            success: function (data) {
                $('#panel-permissions').html(data.permisionHtml);
                ActionChecked('#perm-view', '.view-checkbox');
                ActionChecked('#perm-add', '.add-checkbox');
                ActionChecked('#perm-edit', '.edit-checkbox');
                ActionChecked('#perm-delete', '.delete-checkbox');
            }
        });

    });
    $(document.body).on('click', '#submitPermission', function () {
        var perm = [];
        var roleId = $('#roles').val();
        $("#tbody-perm input:checkbox:checked").map(function () {
            perm.push($(this).val());
        });

        $.ajax({
            url: '{{ url(Config::get("sysconfig.prefix")."/rolepermissions") }}/' + roleId,
            type: 'POST',
            data: {
                "permissions": perm,
                "_method": 'PATCH',
                "_token": $('meta[name="csrf-token"]').attr('content'),
            },
            dataType: 'json',
            success: function (response) {
                swal({
                    title: response.title,
                    html: response.message,
                    type: response.status,
                    allowOutsideClick: false
                });
            }
        });
    })
    function ActionChecked(mainCheck, parentCheck) {
        $(mainCheck).on('click', function () {
            if (this.checked) {
                $(parentCheck).each(function () {
                    this.checked = true;
                });
            } else {
                $(parentCheck).each(function () {
                    this.checked = false;
                });
            }
        });
        $(parentCheck).on('click', function () {
            if ($(parentCheck + ':checked').length == $(parentCheck).length) {
                $(mainCheck).prop('checked', true);
            } else {
                $(mainCheck).prop('checked', false);
            }
        });

        if ($(parentCheck + ':checked').length == $(parentCheck).length) {
            $(mainCheck).prop('checked', true);
        } else {
            $(mainCheck).prop('checked', false);
        }
    }
</script>

@endpush