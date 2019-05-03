<script src="{{asset('backend/assets/js/jquery.gritter.js')}}"></script>

<script>
$(document).on('click', '.delete_confirm', function (e) {

    var Id = {!! $vid !!} ;
    var parent = $(this).parent("td").parent("tr");
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
                        "_token": '{{ csrf_token() }}',
                    },
                    dataType: 'json'
                }).done(function (response) {
                    if (response.status === 'success' || response.status === 'info') {
                        parent.fadeOut('slow');
                    }
                    swal({
                        title: response.title,
                        html: response.message,
                        type: response.status,
                        allowOutsideClick: false
                    });

                })
                        .fail(function () {
                            swal('Oops...', 'Something went wrong with ajax !', 'error');
                        });
            });
        },
        allowOutsideClick: false
    });
    e.preventDefault();
});


function changestatus(id) {
    value = parseInt($('#status_' + id).val());
    if (value === 1) {
        status = 0;
    } else {
        status = 1;
    }

    $.ajax({
        type: 'POST',
        url: "{{url(Config::get('sysconfig.prefix').'/'.$entity)}}/status",
        data: {
            '_token': '{{ csrf_token() }}',
            'status': status,
            'id': id
        },
        success: function (data) {
            if (data.status) {
                $('#status_' + id).val(data.status);
                if (data.status === '1') {
                    text = "The record has published";
                    class_name = "gritter-success";
                } else {
                    text = "The record hasn't published";
                    class_name = "gritter-warning";
                }
                $.gritter.add({
                    // (string | mandatory) the heading of the notification
                    title: 'Notification !!!',
                    // (string | mandatory) the text inside the notification
                    text: text,
                    class_name: class_name
                });

            }

        }

    });

}

function changefrontend(id){
     value = parseInt($('#front_' + id).val());
    if (value === 1) {
        status = 0;
    } else {
        status = 1;
    }

    $.ajax({
        type: 'POST',
        url: "{{url(Config::get('sysconfig.prefix').'/'.$entity)}}/is_featured",
        data: {
            '_token': '{{ csrf_token() }}',
            'isfeatured': status,
            'id': id
        },
        success: function (data) {
            if (data.status) {
                $('#status_' + id).val(data.status);
                if (data.status === '1') {
                    text = "The record has published to home page";
                    class_name = "gritter-success"
                } else {
                    text = "The record hasn't published to home page";
                    class_name = "gritter-warning"
                }
                $.gritter.add({
                    // (string | mandatory) the heading of the notification
                    title: 'Notification !!!',
                    // (string | mandatory) the text inside the notification
                    text: text,
                    class_name: class_name
                });

            }

        }

    });
}
</script>
