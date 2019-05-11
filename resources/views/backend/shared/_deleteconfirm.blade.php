<script type="text/javascript">
    $(document).on('click', '.delete_action', function (e) {

        var Id = {!! $vid !!}
        ;
        // var parent = $(this).parent("td").parent("tr");
        swal({
            title: 'Are you sure?',
            html: "Are yous sure wanted to delete it?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        url: '{{ url(Config::get("sysconfig.prefix")."/".$entity) }}/' + Id,
                        type: 'POST',
                        data: {
                            "id": Id,
                            "_method": 'DELETE',
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                        },
                        dataType: 'json'
                    }).done(function (response) {
                        if (response.status === 'success' || response.status === 'info') {
                            //parent.fadeOut('slow');
                           // $('#' + response.id).fadeOut('slow');
                           // window.LaravelDataTables[tbladmin].ajax.reload();
                            window.LaravelDataTables[tbladmin].draw();
                        }
                        swal({
                            title: response.title,
                            html: response.message,
                            type: response.status,
                            allowOutsideClick: false
                        });

                    }).fail(function () {
                        swal('Oops...', 'Something went wrong with ajax !', 'error');
                    });
                });
            },
            allowOutsideClick: false
        });
        e.preventDefault();
    });

    $("body").delegate('.published', 'click', function (e) {
        var status = $(this).data('status');
        var id = $(this).data('id');
        $.ajax({
            url: "{{url(Config::get('sysconfig.prefix').'/'.$entity)}}/status",
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
                    // icon: notifyicon,
                    message: data.message
                }, {
                    type: notifytype
                });
                $('#action_' + data.id).html(data.html);
            }
        });
    });

    $('#'+tbladmin).on("change", ".m-group-checkable", function () {
        var e = $(this).closest("table").find("td:first-child .m-checkable"), a = $(this).is(":checked");
        $(e).each(function () {
            a ? ($(this).prop("checked", !0), $(this).closest("tr").addClass("active")) : ($(this).prop("checked", !1), $(this).closest("tr").removeClass("active"))
        }
        )
    });
    $('#'+tbladmin).on("change", "tbody tr .m-checkbox", function () {
        $(this).parents("tr").toggleClass("active");
    });
    $("body").delegate('#active-record,#unactive-record', 'click', function (e) {
        var status = $(this).data('status');
        if(status === 1){
            message = 'Are yous sure wanted to active?';
            btntext = 'Yes, Active it!';
        }else{
            message = 'Are yous sure wanted to unactive?';
             btntext = 'Yes, Unctive it!';
        }
        swal({
            title: 'Are you sure?',
            html: message,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: btntext,
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                        var checked = [];
                    $.each($("input[name='cbo_selected']:checked"), function () {
                        checked.push($(this).val());
                    });
                    var strId = checked.join(',');
                    $.ajax({
                        url: "{{url(Config::get('sysconfig.prefix').'/'.$entity)}}/multstatus",
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'checkedid': strId,
                            'status': status
                        }

                    }).done(function (response) {
                        swal({
                            title: response.title,
                            html: response.message,
                            type: response.status,
                            allowOutsideClick: false
                        });
                     // window.LaravelDataTables[tbladmin].ajax.reload();
                      window.LaravelDataTables[tbladmin].draw();
                    }).fail(function () {
                        swal('Oops...', 'Something went wrong with ajax !', 'error');
                    });
                });
            }
        });
    });
    
     $("body").delegate('#remove-record,#delete-record', 'click', function (e) {
         var type = $(this).data('type');
         if(type ==='delete'){
              message = 'Are yous sure wanted to delete?';
         }else if(type ==='remove'){
              message = 'Are yous sure wanted to remove to trash?';
         }
           
        swal({
            title: 'Are you sure?',
            html: message,
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, do it!',
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve) {
                        var checked = [];
                    $.each($("input[name='cbo_selected']:checked"), function () {
                        checked.push($(this).val());
                    });
                    var strId = checked.join(',');
                    $.ajax({
                        url: "{{url(Config::get('sysconfig.prefix').'/'.$entity)}}/0",
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            "_method": 'DELETE',
                            '_token': $('meta[name="csrf-token"]').attr('content'),
                            'checkedid': strId,
                            'type': type
                        }

                    }).done(function (response) {
                        swal({
                            title: response.title,
                            html: response.message,
                            type: response.status,
                            allowOutsideClick: false
                        });
                     // window.LaravelDataTables[tbladmin].ajax.reload();
                      window.LaravelDataTables[tbladmin].draw();
                    }).fail(function () {
                        swal('Oops...', 'Something went wrong with ajax !', 'error');
                    });
                });
            }
        });
    });
</script>
