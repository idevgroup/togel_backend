@extends('frontend.template.main')

@section('content')
<!-- Carousel Slider -->
<div class="js-carousel u-carousel-v5"
     data-infinite="true"
     data-autoplay="true"
     data-speed="8000"
     data-pagi-classes="u-carousel-indicators-v34 g-absolute-centered--y g-left-auto g-right-30 g-right-100--md"
     data-calc-target="#js-header">

    <!-- Carousel Slides -->
    <div class="js-slide h-100 g-flex-centered g-bg-img-hero g-bg-cover g-bg-black-opacity-0_3--after" style="background-image: url({{asset('frontend/img-temp/1920x1080/img5.jpg')}});">
        <div class="container">
            <div class="g-max-width-600 g-pos-rel g-z-index-1">
                <a class="d-block g-text-underline--none--hover" href="#">
                    <span class="d-block g-color-white g-font-size-20--md mb-2">
                        Making an Impact : <span class="g-brd-bottom--dashed g-brd-2 g-brd-primary g-color-primary g-font-weight-700 g-pb-2">Careers Day</span>
                    </span>
                    <span class="d-block g-color-white g-font-secondary g-font-size-25 g-font-size-45--md g-line-height-1_4">
                        Explore career options October 12 at the Unify Arena.
                    </span>
                </a>
            </div>

            <!-- Go to Button -->
            <a class="js-go-to d-flex align-items-center g-color-white g-pos-abs g-bottom-0 g-z-index-1 g-text-underline--none--hover g-pb-60" href="#!" data-target="#content">
                <span class="d-block u-go-to-v4 mr-3"></span>
                <span class="g-brd-bottom--dashed g-brd-white-opacity-0_5 mr-1">scroll down</span> to find out more
            </a>
            <!-- End Go to Button -->
        </div>
    </div>
    <!-- End Carousel Slides -->

    <!-- Carousel Slides -->
    <div class="js-slide h-100 g-flex-centered g-bg-img-hero g-bg-cover g-bg-black-opacity-0_2--after" style="background-image: url({{asset('frontend/img-temp/1920x1080/img6.jpg')}});">
        <div class="container">
            <div class="g-max-width-600 g-pos-rel g-z-index-1">
                <a class="d-block g-text-underline--none--hover" href="#">
                    <span class="d-block g-color-white g-font-size-20--md mb-2">
                        Discover Unify's Faculty of <span class="g-brd-bottom--dashed g-brd-2 g-brd-primary g-color-primary g-font-weight-700 g-pb-2">Chemistry</span>
                    </span>
                    <span class="d-block g-color-white g-font-secondary g-font-size-25 g-font-size-45--md g-line-height-1_4">
                        Student work, Success stories, Faculty profiles, 360&#176; tours &amp; more
                    </span>
                </a>
            </div>

            <!-- Go to Button -->
            <a class="js-go-to d-flex align-items-center g-color-white g-pos-abs g-bottom-0 g-z-index-1 g-text-underline--none--hover g-pb-60" href="#!" data-target="#content">
                <span class="d-block u-go-to-v4 mr-3"></span>
                <span class="g-brd-bottom--dashed g-brd-white-opacity-0_5 mr-1">scroll down</span> to find out more
            </a>
            <!-- End Go to Button -->
        </div>
    </div>
    <!-- End Carousel Slides -->

    <!-- Carousel Slides -->
    <div class="js-slide h-100 g-flex-centered g-bg-img-hero g-bg-pos-top-center g-bg-cover g-bg-black-opacity-0_3--after" style="background-image: url({{asset('frontend/img-temp/1920x1080/img7.jpg')}});">
        <div class="container">
            <div class="g-max-width-600 g-pos-rel g-z-index-1">
                <a class="d-block g-text-underline--none--hover" href="#">
                    <span class="d-block g-color-white g-font-size-20--md mb-2">
                        Fall <span class="g-brd-bottom--dashed g-brd-2 g-brd-primary g-color-primary g-font-weight-700 g-pb-2">Webinar Series</span>
                    </span>
                    <span class="d-block g-color-white g-font-secondary g-font-size-25 g-font-size-45--md g-line-height-1_4">
                        See our full schedule and register now
                    </span>
                </a>
            </div>

            <!-- Go to Button -->
            <a class="js-go-to d-flex align-items-center g-color-white g-pos-abs g-bottom-0 g-z-index-1 g-text-underline--none--hover g-pb-60" href="#!" data-target="#content">
                <span class="d-block u-go-to-v4 mr-3"></span>
                <span class="g-brd-bottom--dashed g-brd-white-opacity-0_5 mr-1">scroll down</span> to find out more
            </a>
            <!-- End Go to Button -->
        </div>
    </div>
    <!-- End Carousel Slides -->
</div>
<!-- End Carousel Slider -->

<!-- Find a Course -->
<div id="content" class="u-shadow-v34 g-bg-main g-pos-rel g-z-index-1 g-pt-40 g-pb-10">
    <div class="container">
        <form class="row align-items-md-center">
            <div class="col-md-4 g-mb-30">
                <h1 class="h2 g-color-white mb-0">Find a course</h1>
            </div>

            <div class="col-md-6 g-mb-30">
                <input class="form-control h-100 u-shadow-v19 g-brd-none g-bg-white g-font-size-16 g-rounded-30 g-px-25 g-py-13" type="text" placeholder="Search for courses">
            </div>

            <div class="col-md-2 g-mb-30">
                <button class="btn u-shadow-v32 input-group-addon d-flex align-items-center g-brd-none g-color-white g-color-primary--hover g-bg-primary g-bg-white--hover g-font-size-16 g-rounded-30 g-transition-0_2 g-px-30 g-py-13" type="button">
                    Search
                    <i class="ml-3 fa fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>
<!-- End Find a Course -->
@endsection