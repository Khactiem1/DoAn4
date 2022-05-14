<!DOCTYPE html>
<html lang="en" ng-app="my-app" ng-controller="loginController">
<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Đăng nhập Admin</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('Admin\favicon.ico')}}">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{ asset('Admin\assets\css\vendor.min.css')}}">
    <link rel="stylesheet" href="{{ asset('Admin\assets\vendor\icon-set\style.css')}}">

    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{ asset('Admin\assets\css\theme.min.css?v=1.0')}}">
    <style>
        .invalid .auth-form__input{
            border-color: #ed4c78;
            box-shadow: 0 0 10px rgb(237, 76, 120, 10%);
        }
        .invalid .input-group-append{
            top: -20px;
        }
        .mess__login{
            width: 100%;
            font-size: 15px;
            color: #ed4c78;
            display: block;
            margin-bottom: 1.5rem;
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
            z-index: 1000;
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
    </style>
</head>

<body>
<div class="content__notification">

</div>
<!-- ========== MAIN CONTENT ========== -->
<main id="content" role="main" class="main">
    <div class="position-fixed top-0 right-0 left-0 bg-img-hero" style="height: 32rem; background-image: url({{ asset('Admin/assets/svg/components/abstract-bg-4.svg')}});">
        <!-- SVG Bottom Shape -->
        <figure class="position-absolute right-0 bottom-0 left-0">
            <svg preserveaspectratio="none" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewbox="0 0 1921 273">
                <polygon fill="#fff" points="0,273 1921,273 1921,0 "></polygon>
            </svg>
        </figure>
        <!-- End SVG Bottom Shape -->
    </div>

    <!-- Content -->
    <div class="container py-5 py-sm-7">
        <a class="d-flex justify-content-center mb-5" href="index.html">
            <img class="z-index-2" src="{{ asset('Admin\assets\svg\logos\logo.svg')}}" alt="Image Description" style="width: 8rem;">
        </a>

        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <!-- Card -->
                <div class="card card-lg mb-5">
                    <div class="card-body">
                        <!-- Form -->
                        <form class="js-validate">
                            <div class="text-center">
                                <div class="mb-5">
                                    <h1 class="display-4">Đăng nhập admin</h1>
                                </div>
                            </div>
                            <span class="mess__login">

                            </span>

                            <!-- Form Group -->
                            <div class="form-group">
                                <label class="input-label" for="name">Tên đăng nhập</label>

                                <input type="text" class="form-control auth-form__input" name="name" id="name" tabindex="1" placeholder="Nhập tài khoản" aria-label="name">
                                <span class="form-message"></span>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div class="form-group">
                                <label class="input-label" for="password">Mật khẩu</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" class="js-toggle-password form-control auth-form__input" name="password" id="password" placeholder="Nhập mật khẩu" data-hs-toggle-password-options='{
                                 "target": "#changePassTarget",
                                 "defaultClass": "tio-hidden-outlined",
                                 "showClass": "tio-visible-outlined",
                                 "classChangeTarget": "#changePassIcon"
                                }'>
                                    <span class="form-message"></span>
                                    <div id="changePassTarget" class="input-group-append">
                                        <a class="input-group-text" href="javascript:;">
                                            <i id="changePassIcon" class="tio-visible-outlined"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Checkbox -->
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input auth-form__input" id="remember" name="remember">
                                    <label class="custom-control-label text-muted" for="remember"> Remember me</label>
                                </div>
                            </div>
                            <!-- End Checkbox -->

                            <button ng-click="login()" type="button" class="btn btn-lg btn-block btn-primary auth-form__submit">
                                <span class="spinner-text">
                                    Đăng nhập
                                </span>
                                <div class="loading">
                                    <span class="spinner-border spinner-border-xs"></span>
                                </div>
                            </button>
                        </form>
                        <!-- End Form -->
                    </div>
                </div>
                <!-- End Card -->

                <!-- Footer -->
                <div class="text-center">
                    <small class="text-cap mb-4">Đăng nhập để vào trang quản trị</small>
                </div>
                <!-- End Footer -->
            </div>
        </div>
    </div>
    <!-- End Content -->
</main>
<!-- ========== END MAIN CONTENT ========== -->


<!-- JS Implementing Plugins -->
<script src="{{ asset('Admin\assets\js\vendor.min.js')}}"></script>

<!-- JS Front -->
<script src="{{ asset('Admin\assets\js\theme.min.js')}}"></script>

<!-- JS Plugins Init. -->
<script src="{{ asset('app\lib\angular.min.js')}}"></script>
<script src="{{ asset('app\app.js')}}"></script>
<script src="{{ asset('app\controller\admin\loginController.js')}}"></script>
<script src="{{ asset('app\message.js')}}"></script>
<script>
    var isFormValid = true;
    $(document).on('ready', function () {
        // INITIALIZATION OF SHOW PASSWORD
        // =======================================================
        $('.js-toggle-password').each(function () {
            new HSTogglePassword(this).init()
        });
        const mess__login = document.querySelector('.mess__login');
        const input = document.querySelectorAll('.auth-form__input');
        function remove_oninput(element){
            var message = element.querySelector('.form-message');
            message.innerText = '';
            element.classList.remove('invalid');
        }
        function add__blur(element,messages){
            var message = element.querySelector('.form-message');
            message.innerText = messages;
            element.classList.add('invalid');
        }
        input.forEach((blurs,index) =>{
            blurs.onblur = function(){
                if(index == 0){
                    function tests(){
                        return input[0].value.trim().length >= 1 ? undefined :  `Hãy nhập tên tài khoản`;
                    }
                    if(tests() == null){
                    }
                    else{
                        var mess = tests();
                        add__blur(input[0].parentElement,mess);
                    }
                }
                else if(index == 1){
                    function tests(){
                        return input[1].value.trim().length >= 1 ? undefined :  `Hãy nhập mật khẩu`;
                    }
                    if(tests() == null){
                    }
                    else{
                        var mess = tests();
                        add__blur(input[1].parentElement,mess);
                    }
                }
            }
            blurs.oninput = function(){
                if(index == 0){
                    remove_oninput(input[0].parentElement);
                    isFormValid = true;
                    mess__login.innerHTML = '';
                }
                else if(index == 1){
                    remove_oninput(input[1].parentElement);
                    isFormValid = true;
                    mess__login.innerHTML = '';
                }
            }
        })
        const submit = document.querySelector('.auth-form__submit');
        submit.onclick = function(){
            for(var i = 0; i < input.length;i++){
                if(i == 0){
                    function tests(){
                        return input[0].value.trim().length >= 1 ? undefined :  `Hãy nhập tên tài khoản`;
                    }
                    if(tests() == null){
                    }
                    else{
                        var mess = tests();
                        add__blur(input[0].parentElement,mess);
                        isFormValid = false;
                    }
                }
                else if(i == 1){
                    function tests(){
                        return input[1].value.trim().length >= 1 ? undefined :  `Hãy nhập mật khẩu`;
                    }
                    if(tests() == null){
                    }
                    else{
                        var mess = tests();
                        add__blur(input[1].parentElement,mess);
                        isFormValid = false;
                    }
                }
            }
            if(isFormValid == true){

            }
        }
    });
</script>

<!-- IE Support -->
<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="{{ asset('Admin\assets\vendor\babel-polyfill\polyfill.min.js')}}"><\/script>');
</script>
</body>
</html>
