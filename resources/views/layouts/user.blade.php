<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<!-- Head BEGIN -->
<head>
    <meta charset="utf-8">
    @yield('title')

    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <meta content="Metronic Shop UI description" name="description">
    <meta content="Metronic Shop UI keywords" name="keywords">
    <meta content="keenthemes" name="author">

    <meta property="og:site_name" content="-CUSTOMER VALUE-">
    <meta property="og:title" content="-CUSTOMER VALUE-">
    <meta property="og:description" content="-CUSTOMER VALUE-">
    <meta property="og:type" content="website">
    <meta property="og:image" content="-CUSTOMER VALUE-"><!-- link to image for socio -->
    <meta property="og:url" content="-CUSTOMER VALUE-">

    <link rel="shortcut icon" href="{{ asset('Admin\favicon.ico')}}">

    <!-- Fonts START -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|PT+Sans+Narrow|Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900&amp;subset=all" rel="stylesheet" type="text/css"><!--- fonts for slider on the index page -->
    <!-- Fonts END -->

    <!-- Global styles START -->
    <link href="{{asset('')}}Account/theme/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('')}}Account/theme/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Global styles END -->

    <!-- Page level plugin styles START -->
    <!-- for slider-range -->
    <link rel="stylesheet" href="{{asset('')}}Account/theme/assets/plugins/jquery.range.css">
    <link href="{{asset('')}}Account/theme/assets/pages/css/animate.css" rel="stylesheet">
    <link href="{{asset('')}}Account/theme/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet">
    <link href="{{asset('')}}Account/theme/assets/plugins/owl.carousel/assets/owl.carousel.css" rel="stylesheet">
    <!-- Page level plugin styles END -->

    <!-- Theme styles START -->
    <link href="{{asset('')}}Account/theme/assets/pages/css/components.css" rel="stylesheet">
    <link href="{{asset('')}}Account/theme/assets/pages/css/slider.css" rel="stylesheet">
    <link href="{{asset('')}}Account/theme/assets/pages/css/style-shop.css" rel="stylesheet" type="text/css">
    <link href="{{asset('')}}Account/theme/assets/corporate/css/style.css" rel="stylesheet">
    <link href="{{asset('')}}Account/theme/assets/corporate/css/style-responsive.css" rel="stylesheet">
    <link href="{{asset('')}}Account/theme/assets/corporate/css/themes/red.css" rel="stylesheet" id="style-color">
    <link href="{{asset('')}}Account/theme/assets/corporate/css/custom.css" rel="stylesheet">
    <!-- Theme styles END -->
    <style>
        .invalid .auth-form__input{
            border-color: #ed4c78;
            box-shadow: 0 0 10px rgb(237, 76, 120, 10%);
        }
        .form-message{
            width: 100%;
            margin-top: 0.25rem;
            font-size: 12px;
            color: #ed4c78;
        }
        .auth-form__submit{
            position: relative;
        }
        .loading{
            position: absolute;
            width: 100%;
            height: 100%;
            margin: 0 auto;
            top: 0;
            left: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .icon-loading{
            position: absolute;
        }
        .auth-form__submit .spinner-border{
            display: none;
        }
        .auth-form__submit.submit-loadding .spinner-border{
            display: block;
        }
        .auth-form__submit.submit-loadding .spinner-text{
            visibility: hidden;
        }
        .pagination>.disabled>a, .pagination>.disabled>a:focus, .pagination>.disabled>a:hover, .pagination>.disabled>span, .pagination>.disabled>span:focus, .pagination>.disabled>span:hover {
            color: #777;
            cursor: not-allowed;
            background-color: #fff;
            border-color: #ddd;
        }
        .pagination>li>a, .pagination>li>span {
            position: relative;
            float: left;
            padding: 6px 12px;
            margin-left: -1px;
            line-height: 1.42857143;
            color: #337ab7;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        .pagination>.active>a, .pagination>.active>a:focus, .pagination>.active>a:hover, .pagination>.active>span, .pagination>.active>span:focus, .pagination>.active>span:hover {
            z-index: 3;
            color: #fff;
            cursor: default;
            background-color: #337ab7;
            border-color: #337ab7;
        }
        /*    toast*/
        .content__notification {
            position: fixed;
            width: 300px;
            top: 8px;
            right: 20px;
            z-index: 100000;
            transition: all ease 0.3s;
        }

        .new__notification {
            position: relative;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 12px rgb(0, 0, 0,0.5);
            background-color: #F3F3F3;
            color: #1e2022;
            opacity: 0;
            visibility: hidden;
            transition: all ease 0.3s;
            right: -280px;
        }

        .new__notification span {
            margin-left: 23px;
            padding: 0 0 0 6px;
        }

        .new__notification-close {
            color: #1e2022;
            cursor: pointer;
            transition: all ease 0.2s;
        }

        .new__notification-close:hover {
            color: #616161;
        }

        .new__notification::before {
            content: '';
            position: absolute;
            width: 5px;
            left: -5px;
            top: 0;
            height: 100%;
        }

        .new__notification.new__notification-success::before {
            background-color: #47D25D;
        }

        .new__notification.new__notification-error::before {
            background-color: #FE573B;
        }

        .new__notification.new__notification-active {
            visibility: visible;
            opacity: 1;
            right: 0px;
        }

        .new__notification .new__notification-icon {
            position: absolute;
        }

        .new__notification-iconTrue {
            color: #47D25D;
        }

        .new__notification-iconFalse {
            color: #FE573B;
        }
        .new__notification.new__notification-active.new__notification-hidden {
            transition: all ease 0.3s;
            opacity: 0;
        }
        .none{
            display: none;
        }

        .pi-img-wrapper{
            position: relative;
            height: 300px;
        }
        .img-responsive{
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            margin: auto 0;
        }
        .dropdown-toggle{
            text-transform: none;
        }
        .trademark-image{
            height: 20px;
            margin-left: 12px;
        }
        .new__notification-iconTrue {
            color: #47D25D;
        }
        .new__notification-iconTrue:before{
            content: '\2714';
        }
        .new__notification-iconFalse:before{
            content: '\2639';
        }
        .new__notification-close:before{
            content: '\2716';
        }
        .new__notification-close{
            color: #1e2022;
            cursor: pointer;
            transition: all ease 0.2s;
        }
        .new__notification-iconFalse{
            color: #FE573B;
        }
        .option{
            border: solid 1px #ccc;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            border-radius: 0.5rem !important;
            margin-bottom: 12px;
            cursor: pointer;
        }
        .option.active{
            border-color: #e84d1c;
        }
        .option-price,.option-color{
            margin-top: 12px;
        }
        .option-price span{
            text-decoration-line:line-through;
            color: #ccc;
        }
        .option-color{
            display: flex;
            align-items: center;
        }
        .option-color-view{
            margin-left: 8px;
            width: 25px;
            height: 25px;
            border: solid 1px #ccc;
            border-radius: 5px !important;
            display: inline-block;
        }
        @media only screen and (min-width: 768px) {
            .sidebar{
                --space: 8rem;
                --offset: var(--space);
                flex-grow: 1;
                flex-basis: 300px;
                align-self: start;
                position: sticky;
                top: var(--offset);
            }
        }
        @yield('css')
    </style>
    @yield('cssLink')
</head>
<!-- Head END -->

<!-- Body BEGIN -->
<body id="body" ng-app="my-app" ng-controller="myController" class="ecommerce">
<div class="content__notification">

</div>

    @include('partials.User.header')
    @yield('content')
    @include('partials.User.footer')



<!-- Load javascripts at bottom, this will reduce page load time -->
<!-- BEGIN CORE PLUGINS (REQUIRED FOR ALL PAGES) -->
<!--[if lt IE 9]>
<script src="{{asset('')}}Account/theme/assets/plugins/respond.min.js"></script>
<![endif]-->
<script src="{{asset('')}}Account/theme/assets/plugins/jquery.min.js" type="text/javascript"></script>
<script src="{{asset('')}}Account/theme/assets/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<script src="{{asset('')}}Account/theme/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{{asset('')}}Account/theme/assets/corporate/scripts/back-to-top.js" type="text/javascript"></script>
<script src="{{asset('')}}Account/theme/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL JAVASCRIPTS (REQUIRED ONLY FOR CURRENT PAGE) -->
<script src="{{asset('')}}Account/theme/assets/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script><!-- pop up -->
<script src="{{asset('')}}Account/theme/assets/plugins/owl.carousel/owl.carousel.min.js" type="text/javascript"></script><!-- slider for products -->
<script src='{{asset('')}}Account/theme/assets/plugins/zoom/jquery.zoom.min.js' type="text/javascript"></script><!-- product zoom -->
<script src="{{asset('')}}Account/theme/assets/plugins/bootstrap-touchspin/bootstrap.touchspin.js" type="text/javascript"></script><!-- Quantity -->

<script src="{{asset('')}}Account/theme/assets/corporate/scripts/layout.js" type="text/javascript"></script>
<script src="{{asset('')}}Account/theme/assets/pages/scripts/bs-carousel.js" type="text/javascript"></script>
<!-- for slider-range -->
<script src="{{asset('')}}Account/theme/assets/plugins/jquery.range.js"></script>

@yield('javascriptForm')
<!-- END PAGE LEVEL JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
