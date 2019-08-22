
<!-- begin::Footer -->
<footer class="m-grid__item m-footer ">
    <div class="m-container m-container--fluid m-container--full-height m-page__container">
        <div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
            <div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
                <span class="m-footer__copyright">
                    2019 &copy; IDG
                </span>
            </div>
        </div>
    </div>
</footer>

<!-- end::Footer -->
</div>

<!-- end::Quick Sidebar -->

<!-- begin::Scroll Top -->
<div id="m_scroll_top" class="m-scroll-top">
    <i class="la la-arrow-up"></i>
</div>

<!-- end::Scroll Top -->
<!--begin::Global Theme Bundle -->
<script src="{{asset('backend/assets/vendors/base/vendors.bundle.js')}}" type="text/javascript"></script>
<script src="{{asset('backend/assets/demo/default/base/scripts.bundle.js')}}" type="text/javascript"></script>

<!--end::Global Theme Bundle -->
<!-----Pusher------->
<script src="https://js.pusher.com/4.4/pusher.min.js"></script>

<script>
@if (app() -> environment() !== 'production')
// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;
@endif
        var pusher = new Pusher('a8eaccc69a2429346e3d', {
            cluster: 'eu',
                    forceTLS: true
        });

var channel = pusher.subscribe('member-channel');
channel.bind('member-event', function (data) {
    var dataJSON = data
    if (dataJSON.datamember.proc_type === 'deposit') {
        notifytype = 'success';
        notifyicon = 'la la-info-circle';
        notifytitle = "{{trans('labels.deposit')}}";
        url = "{{url(Config::get('sysconfig.prefix'))}}/deposittransactions";
    } else if (dataJSON.datamember.proc_type === 'withdraw') {
        notifytype = 'warning';
        notifyicon = 'la la-warning';
        notifytitle = "{{trans('labels.withdraw')}}";
        url = "{{url(Config::get('sysconfig.prefix'))}}/withdrawtransactions";
    }
    var html = '<p>ID: ' + dataJSON.datamember.memberId + ' <br/>Name: ' + dataJSON.datamember.memberName + ' <br/> Amount: ' + dataJSON.datamember.amount + '</p>';
    $.notify({
        title: notifytitle,
        icon: 'icon ' + notifyicon,
        message: html,
        url: url,
        target: '_self'
    }, {
        delay: 0,
        type: notifytype,
        autoHide: false,
        clickToHide: false,
        style: 'bootstrap'
    });
});
</script>
<!--end::Page Vendors -->

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>


<!--end::Page Scripts -->
@include('sweet::alert')
@stack('javascript') 
</body>

<!-- end::Body -->
</html>