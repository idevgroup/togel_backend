@include('backend.template.inc.header')

@include('backend.template.inc.topbar')
<!-- END: Header -->

<!-- begin::Body -->
<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">

    <!-- BEGIN: Left Aside -->
    <button class="m-aside-left-close  m-aside-left-close--skin-dark " id="m_aside_left_close_btn"><i class="la la-close"></i></button>
    <div id="m_aside_left" class="m-grid__item	m-aside-left  m-aside-left--skin-dark ">

        @include('backend.template.inc.left_side')
    </div>

    <!-- END: Left Aside -->
    <div class="m-grid__item m-grid__item--fluid m-wrapper">
       {{-- @include('backend.template.inc.breadcrumbs')--}}
       <div class="m-subheader d-none">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h3 class="m-subheader__title ">@stack('title','Dashboard')</h3>
                </div>
          
            </div>
        </div>
         <!-- END: Subheader -->
        <div class="m-content">
            @yield('content')
        </div>
<!-- end:: Body -->
       
    </div>
</div>

@include('backend.template.inc.footer')