<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8" />
        <title>   @stack('title','Management System')&nbsp;| ZENTOGEL.NET</title>
        <meta name="description" content="Latest updates and statistic charts">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--begin::Web font -->
        <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
        <script>
        WebFont.load({
            google: {"families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]},
            active: function () {
                sessionStorage.fonts = true;
            }
        });
        </script>

        <!--end::Web font -->

        <!--begin::Global Theme Styles -->
        <link href="{{ asset('backend/assets/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />

        <!--RTL version:<link href="assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
        <link href="{{ asset('backend/assets/demo/default/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />


        <!--end::Global Theme Styles -->

        <!--begin::Page Vendors Styles -->
        <link href="{{ asset('backend/assets/vendors/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('backend/assets/styles.css') }}" rel="stylesheet" type="text/css" />

        <!--end::Page Vendors Styles -->
        <link rel="shortcut icon" href="{{asset('images/fav.png')}}" />
        @stack('style') 
    </head>

    <!-- end::Head -->

    <!-- begin::Body -->
    <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

        <!-- begin:: Page -->
        <div class="m-grid m-grid--hor m-grid--root m-page">
