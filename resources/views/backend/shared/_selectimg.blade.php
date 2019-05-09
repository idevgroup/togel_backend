<script type="text/javascript" charset="utf8" src="{{asset('backend/assets/fileinput/fileinput-elements.js')}}"></script>
<script type="text/javascript" charset="utf8" src="{{asset('backend/assets/fileinput/fileinput.js')}}"></script>
<script type="text/javascript">
$('{{@$selectElement}}').ace_file_input({
    style: 'well',
    btn_choose: 'Drop files here or click to choose',
    btn_change: null,
    no_icon: 'flaticon-upload',
    droppable: true,
    thumbnail: 'fit', //small | fit
    maxSize: 2000000,
    allowExt: ['jpg', 'jpeg', 'png', 'gif', 'tif', 'tiff', 'bmp'],
    allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif', 'image/tif', 'image/tiff', 'image/bmp'] //html5 browsers only
}).on('file.error.ace', function (event, info) {
    if (info.error_count['size']) {
        Swal(
                'Information!',
                'Your file selected is big 2MB.',
                'warning'
                );
    } else if (info.error_count['ext']) {
        Swal(
                'Information!',
                'Your file seleted is invalid extension',
                'warning'
                );
    }
    event.preventDefault();
});
 
</script>