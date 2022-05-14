<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    @yield('title')

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
        @yield('css')
    </style>
    @yield('cssLink')
</head>

<body class="   footer-offset">
<div class="content__notification">

</div>

<script src="{{ asset('Admin\assets\vendor\hs-navbar-vertical-aside\hs-navbar-vertical-aside-mini-cache.js')}}"></script>


<!-- ONLY DEV -->

<!-- Builder -->
<div id="styleSwitcherDropdown" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow"
     style="width: 35rem;">
    <div class="card card-lg border-0 h-100">
        <div class="card-header align-items-start">
            <div class="mr-2">
                <h3 class="card-header-title">Front Builder</h3>
                <p>Customize your overview page layout. Choose the one that best fits your needs.</p>
            </div>

            <!-- Toggle Button -->
            <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark" href="javascript:;"
               data-hs-unfold-options='{
                  "target": "#styleSwitcherDropdown",
                  "type": "css-animation",
                  "animationIn": "fadeInRight",
                  "animationOut": "fadeOutRight",
                  "hasOverlay": true,
                  "smartPositionOff": true
                 }'>
                <i class="tio-clear tio-lg"></i>
            </a>
            <!-- End Toggle Button -->
        </div>

        <!-- Body -->
        <div class="card-body sidebar-scrollbar">
            <h4 class="mb-1">Layout skins <span id="js-builder-disabled" class="badge badge-soft-danger"
                                                style="opacity: 0">Disabled</span></h4>
            <p>3 kinds of layout skins to choose from.</p>

            <div class="row gx-2 mb-5">
                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="layoutSkinsRadio"
                                   id="layoutSkinsRadio1" checked="" value="default">
                            <label class="custom-checkbox-card-label" for="layoutSkinsRadio1">
                                <img class="custom-checkbox-card-img"
                                     src="{{ asset('Admin\assets\svg\layouts\layouts-sidebar-default.svg')}}" alt="Image Description">
                            </label>
                            <span class="custom-checkbox-card-text">Default</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->

                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="layoutSkinsRadio"
                                   id="layoutSkinsRadio2" value="navbar-dark">
                            <label class="custom-checkbox-card-label" for="layoutSkinsRadio2">
                                <img class="custom-checkbox-card-img" src="{{ asset('Admin\assets\svg\layouts\layouts-sidebar-dark.svg')}}"
                                     alt="Image Description">
                            </label>
                            <span class="custom-checkbox-card-text">Dark</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->

                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="layoutSkinsRadio"
                                   id="layoutSkinsRadio3" value="navbar-light">
                            <label class="custom-checkbox-card-label" for="layoutSkinsRadio3">
                                <img class="custom-checkbox-card-img" src="{{ asset('Admin\assets\svg\layouts\layouts-sidebar-light.svg')}}"
                                     alt="Image Description">
                            </label>
                            <span class="custom-checkbox-card-text">Light</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->
            </div>
            <!-- End Row -->

            <h4 class="mb-1">Sidebar layout options</h4>
            <p>Choose between standard navigation sizing, mini or even compact with icons.</p>

            <div class="row gx-2 mb-5">
                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="sidebarLayoutOptions"
                                   id="sidebarLayoutOptions1" checked="" value="default">
                            <label class="custom-checkbox-card-label" for="sidebarLayoutOptions1">
                                <img class="custom-checkbox-card-img"
                                     src="{{ asset('Admin\assets\svg\layouts\sidebar-default-classic.svg')}}" alt="Image Description">
                            </label>
                            <span class="custom-checkbox-card-text">Default</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->

                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="sidebarLayoutOptions"
                                   id="sidebarLayoutOptions2" value="navbar-vertical-aside-compact-mode">
                            <label class="custom-checkbox-card-label" for="sidebarLayoutOptions2">
                                <img class="custom-checkbox-card-img" src="{{ asset('Admin\assets\svg\layouts\sidebar-compact.svg')}}"
                                     alt="Image Description">
                            </label>
                            <span class="custom-checkbox-card-text">Compact</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->

                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="sidebarLayoutOptions"
                                   id="sidebarLayoutOptions3" value="navbar-vertical-aside-mini-mode">
                            <label class="custom-checkbox-card-label" for="sidebarLayoutOptions3">
                                <img class="custom-checkbox-card-img" src="{{ asset('Admin\assets\svg\layouts\sidebar-mini.svg')}}"
                                     alt="Image Description">
                            </label>
                            <span class="custom-checkbox-card-text">Mini</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->
            </div>
            <!-- End Row -->

            <h4 class="mb-1">Header layout options</h4>
            <p>Choose the primary navigation of your header layout.</p>

            <div class="row gx-2">
                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="headerLayoutOptions"
                                   id="headerLayoutOptions1" value="single">
                            <label class="custom-checkbox-card-label" for="headerLayoutOptions1">
                                <img class="custom-checkbox-card-img" src="{{ asset('Admin\assets\svg\layouts\header-default-fluid.svg')}}"
                                     alt="Image Description">
                            </label>
                            <span class="custom-checkbox-card-text">Default (Fluid)</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->

                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="headerLayoutOptions"
                                   id="headerLayoutOptions2" value="single-container">
                            <label class="custom-checkbox-card-label" for="headerLayoutOptions2">
                                <img class="custom-checkbox-card-img"
                                     src="{{ asset('Admin\assets\svg\layouts\header-default-container.svg')}}" alt="Image Description">
                            </label>
                            <span class="custom-checkbox-card-text">Default (Container)</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->

                <!-- Custom Radio -->
                <div class="col-4 text-center">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="headerLayoutOptions"
                                   id="headerLayoutOptions3" value="double">
                            <label class="custom-checkbox-card-label" for="headerLayoutOptions3">
                                <img class="custom-checkbox-card-img"
                                     src="{{ asset('Admin\assets\svg\layouts\header-double-line-fluid.svg')}}" alt="Image Description">
                            </label>
                            <span class="custom-checkbox-card-text">Double line (Fluid)</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->

                <!-- Custom Radio -->
                <div class="col-4 text-center mt-2">
                    <div class="text-center">
                        <div class="custom-checkbox-card mb-2">
                            <input type="radio" class="custom-checkbox-card-input" name="headerLayoutOptions"
                                   id="headerLayoutOptions4" value="double-container">
                            <label class="custom-checkbox-card-label" for="headerLayoutOptions4">
                                <img class="custom-checkbox-card-img"
                                     src="{{ asset('Admin\assets\svg\layouts\header-double-line-container.svg')}}" alt="Image Description">
                            </label>
                            <span class="custom-checkbox-card-text">Double line (Container)</span>
                        </div>
                    </div>
                </div>
                <!-- End Custom Radio -->
            </div>
            <!-- End Row -->
        </div>
        <!-- End Body -->

        <!-- Footer -->
        <div class="card-footer">
            <div class="row gx-2">
                <div class="col">
                    <button type="button" id="js-builder-reset" class="btn btn-block btn-lg btn-white">
                        <i class="tio-restore"></i> Reset
                    </button>
                </div>
                <div class="col">
                    <button type="button" id="js-builder-preview" class="btn btn-block btn-lg btn-primary">
                        <i class="tio-visible"></i> Preview
                    </button>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Footer -->
    </div>
</div>
<!-- End Builder -->

<!-- Builder Toggle -->
<div class="d-none d-md-block position-fixed bottom-0 right-0 mr-5 mb-10" style="z-index: 3;">
    <div
        style="position: fixed; top: 50%; right: 0; margin-right: -.25rem; transform: translateY(-50%); writing-mode: vertical-rl; text-orientation: sideways;">
        <div class="hs-unfold">
            <a id="builderPopover" class="js-hs-unfold-invoker btn btn-sm btn-soft-dark py-3" href="javascript:;"
               data-template='<div class="d-none d-md-block popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>'
               data-toggle="popover" data-placement="left"
               title="<div class='d-flex align-items-center'>Front Builder <a href='#!' class='close close-light ml-auto'><i id='closeBuilderPopover' class='tio-clear'></i></a></div>"
               data-content="Customize your overview page layout. Choose the one that best fits your needs."
               data-html="true" data-hs-unfold-options='{
                "target": "#styleSwitcherDropdown",
                "type": "css-animation",
                "animationIn": "fadeInRight",
                "animationOut": "fadeOutRight",
                "hasOverlay": true,
                "smartPositionOff": true
               }'>
                <i class="tio-tune mr-2"></i>
                <span class="font-weight-bold text-uppercase">Builder</span>
            </a>
        </div>
    </div>
</div>

<!-- End Builder Toggle -->
@include('partials.Admin.header')
@include('partials.Admin.siderbar')
<main id="content" role="main" class="main pointer-event">

@yield('content')

@include('partials.Admin.footer')
</main>

<!-- ========== END MAIN CONTENT ========== -->

<!-- ========== SECONDARY CONTENTS ========== -->
<!-- Keyboard Shortcuts -->
<div id="keyboardShortcutsSidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
    <div class="card card-lg sidebar-card">
        <div class="card-header">
            <h4 class="card-header-title">Keyboard shortcuts</h4>

            <!-- Toggle Button -->
            <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
               data-hs-unfold-options='{
                "target": "#keyboardShortcutsSidebar",
                "type": "css-animation",
                "animationIn": "fadeInRight",
                "animationOut": "fadeOutRight",
                "hasOverlay": true,
                "smartPositionOff": true
               }'>
                <i class="tio-clear tio-lg"></i>
            </a>
            <!-- End Toggle Button -->
        </div>

        <!-- Body -->
        <div class="card-body sidebar-body sidebar-scrollbar">
            <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
                <div class="list-group-item">
                    <h5 class="mb-1">Formatting</h5>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span class="font-weight-bold">Bold</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">b</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <em>italic</em>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">i</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <u>Underline</u>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">u</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <s>Strikethrough</s>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">Alt</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">s</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span class="small">Small text</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">s</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <mark>Highlight</mark>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">e</kbd>
                        </div>
                    </div>
                </div>
            </div>

            <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
                <div class="list-group-item">
                    <h5 class="mb-1">Insert</h5>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Mention person <a href="#">(@Brian)</a></span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">@</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Link to doc <a href="#">(+Meeting notes)</a></span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">+</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <a href="#">#hashtag</a>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">#hashtag</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Date</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">/date</kbd>
                            <kbd class="d-inline-block mb-1">Space</kbd>
                            <kbd class="d-inline-block mb-1">/datetime</kbd>
                            <kbd class="d-inline-block mb-1">/datetime</kbd>
                            <kbd class="d-inline-block mb-1">Space</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Time</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">/time</kbd>
                            <kbd class="d-inline-block mb-1">Space</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Note box</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">/note</kbd>
                            <kbd class="d-inline-block mb-1">Enter</kbd>
                            <kbd class="d-inline-block mb-1">/note red</kbd>
                            <kbd class="d-inline-block mb-1">/note red</kbd>
                            <kbd class="d-inline-block mb-1">Enter</kbd>
                        </div>
                    </div>
                </div>
            </div>

            <div class="list-group list-group-sm list-group-flush list-group-no-gutters mb-5">
                <div class="list-group-item">
                    <h5 class="mb-1">Editing</h5>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Find and replace</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">r</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Find next</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">n</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Find previous</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">p</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Indent</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Tab</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Un-indent</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Shift</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">Tab</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Move line up</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">Shift</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1"><i class="tio-arrow-large-upward-outlined"></i></kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Move line down</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">Shift</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1"><i
                                    class="tio-arrow-large-downward-outlined font-size-sm"></i></kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Add a comment</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">Alt</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">m</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Undo</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">z</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Redo</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">y</kbd>
                        </div>
                    </div>
                </div>
            </div>

            <div class="list-group list-group-sm list-group-flush list-group-no-gutters">
                <div class="list-group-item">
                    <h5 class="mb-1">Application</h5>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Create new doc</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">Alt</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">n</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Present</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">Shift</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">p</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Share</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">Shift</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">s</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Search docs</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">Shift</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">o</kbd>
                        </div>
                    </div>
                </div>
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-5">
                            <span>Keyboard shortcuts</span>
                        </div>
                        <div class="col-7 text-right">
                            <kbd class="d-inline-block mb-1">Ctrl</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">Shift</kbd> <small class="text-muted">+</small> <kbd
                                class="d-inline-block mb-1">/</kbd>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Body -->
    </div>
</div>
<!-- End Keyboard Shortcuts -->

<!-- Activity -->
<div id="activitySidebar" class="hs-unfold-content sidebar sidebar-bordered sidebar-box-shadow">
    <div class="card card-lg sidebar-card">
        <div class="card-header">
            <h4 class="card-header-title">Activity stream</h4>

            <!-- Toggle Button -->
            <a class="js-hs-unfold-invoker btn btn-icon btn-xs btn-ghost-dark ml-2" href="javascript:;"
               data-hs-unfold-options='{
              "target": "#activitySidebar",
              "type": "css-animation",
              "animationIn": "fadeInRight",
              "animationOut": "fadeOutRight",
              "hasOverlay": true,
              "smartPositionOff": true
             }'>
                <i class="tio-clear tio-lg"></i>
            </a>
            <!-- End Toggle Button -->
        </div>

        <!-- Body -->
        <div class="card-body sidebar-body sidebar-scrollbar">
            <!-- Step -->
            <ul class="step step-icon-sm step-avatar-sm">
                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <div class="step-avatar">
                            <img class="step-avatar-img" src="{{ asset('Admin\assets\img\160x160\img9.jpg')}}" alt="Image Description">
                        </div>

                        <div class="step-content">
                            <h5 class="mb-1">Iana Robinson</h5>

                            <p class="font-size-sm mb-1">Added 2 files to task <a class="text-uppercase" href="#"><i
                                        class="tio-folder-bookmarked"></i> Fd-7</a></p>

                            <ul class="list-group list-group-sm">
                                <!-- List Item -->
                                <li class="list-group-item list-group-item-light">
                                    <div class="row gx-1">
                                        <div class="col-6">
                                            <div class="media">
                              <span class="mt-1 mr-2">
                                <img class="avatar avatar-xs" src="{{ asset('Admin\assets\svg\brands\excel.svg')}}" alt="Image Description">
                              </span>
                                                <div class="media-body text-truncate">
                                                    <span class="d-block font-size-sm text-dark text-truncate"
                                                          title="weekly-reports.xls">weekly-reports.xls</span>
                                                    <small class="d-block text-muted">12kb</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="media">
                              <span class="mt-1 mr-2">
                                <img class="avatar avatar-xs" src="{{ asset('Admin\assets\svg\brands\word.svg')}}" alt="Image Description">
                              </span>
                                                <div class="media-body text-truncate">
                                                    <span class="d-block font-size-sm text-dark text-truncate"
                                                          title="weekly-reports.xls">weekly-reports.xls</span>
                                                    <small class="d-block text-muted">4kb</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <!-- End List Item -->
                            </ul>

                            <small class="text-muted text-uppercase">Now</small>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <span class="step-icon step-icon-soft-dark">B</span>

                        <div class="step-content">
                            <h5 class="mb-1">Bob Dean</h5>

                            <p class="font-size-sm mb-1">Marked <a class="text-uppercase" href="#"><i
                                        class="tio-folder-bookmarked"></i> Fr-6</a> as <span
                                    class="badge badge-soft-success badge-pill"><span
                                        class="legend-indicator bg-success"></span>"Completed"</span></p>

                            <small class="text-muted text-uppercase">Today</small>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <div class="step-avatar">
                            <img class="step-avatar-img" src="{{ asset('Admin\assets\img\160x160\img3.jpg')}}" alt="Image Description">
                        </div>

                        <div class="step-content">
                            <h5 class="h5 mb-1">Crane</h5>

                            <p class="font-size-sm mb-1">Added 5 card to <a href="#">Payments</a></p>

                            <ul class="list-group list-group-sm">
                                <li class="list-group-item list-group-item-light">
                                    <div class="row gx-1">
                                        <div class="col">
                                            <img class="img-fluid rounded ie-sidebar-activity-img"
                                                 src="{{ asset('Admin\assets\svg\illustrations\card-1.svg')}}" alt="Image Description">
                                        </div>
                                        <div class="col">
                                            <img class="img-fluid rounded ie-sidebar-activity-img"
                                                 src="{{ asset('Admin\assets\svg\illustrations\card-2.svg')}}" alt="Image Description">
                                        </div>
                                        <div class="col">
                                            <img class="img-fluid rounded ie-sidebar-activity-img"
                                                 src="{{ asset('Admin\assets\svg\illustrations\card-3.svg')}}" alt="Image Description">
                                        </div>
                                        <div class="col-auto align-self-center">
                                            <div class="text-center">
                                                <a href="#">+2</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>

                            <small class="text-muted text-uppercase">May 12</small>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <span class="step-icon step-icon-soft-info">D</span>

                        <div class="step-content">
                            <h5 class="mb-1">David Lidell</h5>

                            <p class="font-size-sm mb-1">Added a new member to Front Dashboard</p>

                            <small class="text-muted text-uppercase">May 15</small>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <div class="step-avatar">
                            <img class="step-avatar-img" src="{{ asset('Admin\assets\img\160x160\img7.jpg')}}" alt="Image Description">
                        </div>

                        <div class="step-content">
                            <h5 class="mb-1">Rachel King</h5>

                            <p class="font-size-sm mb-1">Marked <a class="text-uppercase" href="#"><i
                                        class="tio-folder-bookmarked"></i> Fr-3</a> as <span
                                    class="badge badge-soft-success badge-pill"><span
                                        class="legend-indicator bg-success"></span>"Completed"</span></p>

                            <small class="text-muted text-uppercase">Apr 29</small>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                        <div class="step-avatar">
                            <img class="step-avatar-img" src="{{ asset('Admin\assets\img\160x160\img5.jpg')}}" alt="Image Description">
                        </div>

                        <div class="step-content">
                            <h5 class="mb-1">Finch Hoot</h5>

                            <p class="font-size-sm mb-1">Earned a "Top endorsed" <i
                                    class="tio-verified text-primary"></i> badge</p>

                            <small class="text-muted text-uppercase">Apr 06</small>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->

                <!-- Step Item -->
                <li class="step-item">
                    <div class="step-content-wrapper">
                  <span class="step-icon step-icon-soft-primary">
                    <i class="tio-user"></i>
                  </span>

                        <div class="step-content">
                            <h5 class="mb-1">Project status updated</h5>

                            <p class="font-size-sm mb-1">Marked <a class="text-uppercase" href="#"><i
                                        class="tio-folder-bookmarked"></i> Fr-3</a> as <span
                                    class="badge badge-soft-primary badge-pill"><span
                                        class="legend-indicator bg-primary"></span>"In progress"</span></p>

                            <small class="text-muted text-uppercase">Feb 10</small>
                        </div>
                    </div>
                </li>
                <!-- End Step Item -->
            </ul>
            <!-- End Step -->

            <a class="btn btn-block btn-white" href="javascript:;">View all <i class="tio-chevron-right"></i></a>
        </div>
        <!-- End Body -->
    </div>
</div>
<!-- End Activity -->

<!-- Welcome Message Modal -->
<div class="modal fade" id="welcomeMessageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-close">
                <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary" data-dismiss="modal"
                        aria-label="Close">
                    <i class="tio-clear tio-lg"></i>
                </button>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="modal-body p-sm-5">
                <div class="text-center">
                    <div class="w-75 w-sm-50 mx-auto mb-4">
                        <img class="img-fluid" src="{{ asset('Admin\assets\svg\illustrations\graphs.svg')}}" alt="Image Description">
                    </div>

                    <h4 class="h1">Welcome to Front</h4>

                    <p>We're happy to see you in our community.</p>
                </div>
            </div>
            <!-- End Body -->

            <!-- Footer -->
            <div class="modal-footer d-block text-center py-sm-5">
                <small class="text-cap mb-4">Trusted by the world's best teams</small>

                <div class="w-85 mx-auto">
                    <div class="row justify-content-between">
                        <div class="col">
                            <img class="img-fluid ie-welcome-brands" src="{{ asset('Admin\assets\svg\brands\gitlab-gray.svg')}}"
                                 alt="Image Description">
                        </div>
                        <div class="col">
                            <img class="img-fluid ie-welcome-brands" src="{{ asset('Admin\assets\svg\brands\fitbit-gray.svg')}}"
                                 alt="Image Description">
                        </div>
                        <div class="col">
                            <img class="img-fluid ie-welcome-brands" src="{{ asset('Admin\assets\svg\brands\flow-xo-gray.svg')}}"
                                 alt="Image Description">
                        </div>
                        <div class="col">
                            <img class="img-fluid ie-welcome-brands" src="{{ asset('Admin\assets\svg\brands\layar-gray.svg')}}"
                                 alt="Image Description">
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Footer -->
        </div>
    </div>
</div>
<!-- End Welcome Message Modal -->

<!-- Create a new user Modal -->
<div class="modal fade" id="inviteUserModal" tabindex="-1" role="dialog" aria-labelledby="inviteUserModalTitle"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content">
            <!-- Header -->
            <div class="modal-header">
                <h4 id="inviteUserModalTitle" class="modal-title">Invite users</h4>

                <button type="button" class="btn btn-icon btn-sm btn-ghost-secondary" data-dismiss="modal"
                        aria-label="Close">
                    <i class="tio-clear tio-lg"></i>
                </button>
            </div>
            <!-- End Header -->

            <!-- Body -->
            <div class="modal-body">
                <!-- Form Group -->
                <div class="form-group">
                    <div class="input-group input-group-merge mb-2 mb-sm-0">
                        <div class="input-group-prepend" id="fullName">
                  <span class="input-group-text">
                    <i class="tio-search"></i>
                  </span>
                        </div>

                        <input type="text" class="form-control" name="fullName" placeholder="Search name or emails"
                               aria-label="Search name or emails" aria-describedby="fullName">

                        <div class="input-group-append input-group-append-last-sm-down-none">
                            <!-- Select -->
                            <div id="permissionSelect" class="select2-custom select2-custom-right">
                                <select class="js-select2-custom custom-select" size="1" style="opacity: 0;"
                                        data-hs-select2-options='{
                              "dropdownParent": "#permissionSelect",
                              "minimumResultsForSearch": "Infinity",
                              "dropdownAutoWidth": true,
                              "dropdownWidth": "11rem"
                            }'>
                                    <option value="guest" selected="">Guest</option>
                                    <option value="can edit">Can edit</option>
                                    <option value="can comment">Can comment</option>
                                    <option value="full access">Full access</option>
                                </select>
                            </div>
                            <!-- End Select -->

                            <a class="btn btn-primary d-none d-sm-block" href="javascript:;">Invite</a>
                        </div>
                    </div>

                    <a class="btn btn-block btn-primary d-sm-none" href="javascript:;">Invite</a>
                </div>
                <!-- End Form Group -->

                <div class="form-row">
                    <h5 class="col modal-title">Invite users</h5>

                    <div class="col-auto">
                        <a class="d-flex align-items-center font-size-sm text-body" href="#">
                            <img class="avatar avatar-xss mr-2" src="{{ asset('Admin\assets\svg\brands\gmail.svg')}}"
                                 alt="Image Description">
                            Import contacts
                        </a>
                    </div>
                </div>

                <hr class="mt-2">

                <ul class="list-unstyled list-unstyled-py-4">
                    <!-- List Group Item -->
                    <li>
                        <div class="media">
                            <div class="avatar avatar-sm avatar-circle mr-3">
                                <img class="avatar-img" src="{{ asset('Admin\assets\img\160x160\img10.jpg')}}" alt="Image Description">
                            </div>

                            <div class="media-body">
                                <div class="row align-items-center">
                                    <div class="col-sm">
                                        <h5 class="text-body mb-0">Amanda Harvey <i class="tio-verified text-primary"
                                                                                    data-toggle="tooltip"
                                                                                    data-placement="top"
                                                                                    title="Top endorsed"></i></h5>
                                        <span class="d-block font-size-sm">amanda@example.com</span>
                                    </div>

                                    <div class="col-sm">
                                        <!-- Select -->
                                        <div id="inviteUserSelect1"
                                             class="select2-custom select2-custom-sm-right d-sm-flex justify-content-sm-end">
                                            <select class="js-select2-custom custom-select-sm" size="1"
                                                    style="opacity: 0;" data-hs-select2-options='{
                                    "dropdownParent": "#inviteUserSelect1",
                                    "minimumResultsForSearch": "Infinity",
                                    "customClass": "custom-select custom-select-sm custom-select-borderless pl-0",
                                    "dropdownAutoWidth": true,
                                    "width": true
                                  }'>
                                                <option value="guest" selected="">Guest</option>
                                                <option value="can edit">Can edit</option>
                                                <option value="can comment">Can comment</option>
                                                <option value="full access">Full access</option>
                                                <option value="remove"
                                                        data-option-template='<span class="text-danger">Remove</span>'>
                                                    Remove
                                                </option>
                                            </select>
                                        </div>
                                        <!-- End Select -->
                                    </div>
                                </div>
                                <!-- End Row -->
                            </div>
                        </div>
                    </li>
                    <!-- End List Group Item -->

                    <!-- List Group Item -->
                    <li>
                        <div class="media">
                            <div class="avatar avatar-sm avatar-circle mr-3">
                                <img class="avatar-img" src="{{ asset('Admin\assets\img\160x160\img3.jpg')}}" alt="Image Description">
                            </div>

                            <div class="media-body">
                                <div class="row align-items-center">
                                    <div class="col-sm">
                                        <h5 class="text-body mb-0">David Harrison</h5>
                                        <span class="d-block font-size-sm">david@example.com</span>
                                    </div>

                                    <div class="col-sm">
                                        <!-- Select -->
                                        <div id="inviteUserSelect2"
                                             class="select2-custom select2-custom-sm-right d-sm-flex justify-content-sm-end">
                                            <select class="js-select2-custom custom-select-sm" size="1"
                                                    style="opacity: 0;" data-hs-select2-options='{
                                    "dropdownParent": "#inviteUserSelect2",
                                    "minimumResultsForSearch": "Infinity",
                                    "customClass": "custom-select custom-select-sm custom-select-borderless pl-0",
                                    "dropdownAutoWidth": true,
                                    "width": true
                                  }'>
                                                <option value="guest" selected="">Guest</option>
                                                <option value="can edit">Can edit</option>
                                                <option value="can comment">Can comment</option>
                                                <option value="full access">Full access</option>
                                                <option value="remove"
                                                        data-option-template='<span class="text-danger">Remove</span>'>
                                                    Remove
                                                </option>
                                            </select>
                                        </div>
                                        <!-- End Select -->
                                    </div>
                                </div>
                                <!-- End Row -->
                            </div>
                        </div>
                    </li>
                    <!-- End List Group Item -->

                    <!-- List Group Item -->
                    <li>
                        <div class="media">
                            <div class="avatar avatar-sm avatar-circle mr-3">
                                <img class="avatar-img" src="{{ asset('Admin\assets\img\160x160\img9.jpg')}}" alt="Image Description">
                            </div>

                            <div class="media-body">
                                <div class="row align-items-center">
                                    <div class="col-sm">
                                        <h5 class="text-body mb-0">Ella Lauda <i class="tio-verified text-primary"
                                                                                 data-toggle="tooltip"
                                                                                 data-placement="top"
                                                                                 title="Top endorsed"></i></h5>
                                        <span class="d-block font-size-sm">Markvt@example.com</span>
                                    </div>

                                    <div class="col-sm">
                                        <!-- Select -->
                                        <div id="inviteUserSelect4"
                                             class="select2-custom select2-custom-sm-right d-sm-flex justify-content-sm-end">
                                            <select class="js-select2-custom custom-select-sm" size="1"
                                                    style="opacity: 0;" data-hs-select2-options='{
                                    "dropdownParent": "#inviteUserSelect4",
                                    "minimumResultsForSearch": "Infinity",
                                    "customClass": "custom-select custom-select-sm custom-select-borderless pl-0",
                                    "dropdownAutoWidth": true,
                                    "width": true
                                  }'>
                                                <option value="guest" selected="">Guest</option>
                                                <option value="can edit">Can edit</option>
                                                <option value="can comment">Can comment</option>
                                                <option value="full access">Full access</option>
                                                <option value="remove"
                                                        data-option-template='<span class="text-danger">Remove</span>'>
                                                    Remove
                                                </option>
                                            </select>
                                        </div>
                                        <!-- End Select -->
                                    </div>
                                </div>
                                <!-- End Row -->
                            </div>
                        </div>
                    </li>
                    <!-- End List Group Item -->

                    <!-- List Group Item -->
                    <li>
                        <div class="media">
                            <div class="avatar avatar-sm avatar-soft-dark avatar-circle mr-3">
                                <span class="avatar-initials">B</span>
                            </div>

                            <div class="media-body">
                                <div class="row align-items-center">
                                    <div class="col-sm">
                                        <h5 class="text-body mb-0">Bob Dean</h5>
                                        <span class="d-block font-size-sm">bob@example.com</span>
                                    </div>

                                    <div class="col-sm">
                                        <!-- Select -->
                                        <div id="inviteUserSelect3"
                                             class="select2-custom select2-custom-sm-right d-sm-flex justify-content-sm-end">
                                            <select class="js-select2-custom custom-select-sm" size="1"
                                                    style="opacity: 0;" data-hs-select2-options='{
                                    "dropdownParent": "#inviteUserSelect3",
                                    "minimumResultsForSearch": "Infinity",
                                    "customClass": "custom-select custom-select-sm custom-select-borderless pl-0",
                                    "dropdownAutoWidth": true,
                                    "width": true
                                  }'>
                                                <option value="guest" selected="">Guest</option>
                                                <option value="can edit">Can edit</option>
                                                <option value="can comment">Can comment</option>
                                                <option value="full access">Full access</option>
                                                <option value="remove"
                                                        data-option-template='<span class="text-danger">Remove</span>'>
                                                    Remove
                                                </option>
                                            </select>
                                        </div>
                                        <!-- End Select -->
                                    </div>
                                </div>
                                <!-- End Row -->
                            </div>
                        </div>
                    </li>
                    <!-- End List Group Item -->
                </ul>
            </div>
            <!-- End Body -->

            <!-- Footer -->
            <div class="modal-footer justify-content-start">
                <div class="row align-items-center flex-grow-1 mx-n2">
                    <div class="col-sm-9 mb-2 mb-sm-0">
                        <input type="hidden" id="inviteUserPublicClipboard"
                               value="https://themes.getbootstrap.com/product/front-multipurpose-responsive-template/">

                        <p class="modal-footer-text">The public share <a href="#">link settings</a>
                            <i class="tio-help-outlined" data-toggle="tooltip" data-placement="top"
                               title="The public share link allows people to view the project without giving access to full collaboration features."></i>
                        </p>
                    </div>

                    <div class="col-sm-3 text-sm-right">
                        <a class="js-clipboard btn btn-sm btn-white text-nowrap" href="javascript:;"
                           data-toggle="tooltip" data-placement="top" title="Copy to clipboard!"
                           data-hs-clipboard-options='{
                    "type": "tooltip",
                    "successText": "Copied!",
                    "contentTarget": "#inviteUserPublicClipboard",
                    "container": "#inviteUserModal"
                   }'>
                            <i class="tio-link mr-1"></i> Copy link</a>
                    </div>
                </div>
            </div>
            <!-- End Footer -->
        </form>
    </div>
</div>
<!-- End Create a new user Modal -->
<!-- ========== END SECONDARY CONTENTS ========== -->


<!-- JS Implementing Plugins -->
<script src="{{ asset('Admin\assets\js\vendor.min.js')}}"></script>


<!-- JS Front -->
<script src="{{ asset('Admin\assets\js\theme.min.js')}}"></script>

<!-- JS Plugins Init. -->
<script>
    $(document).on('ready', function () {
        // ONLY DEV
        // =======================================================

        if (window.localStorage.getItem('hs-builder-popover') === null) {
            $('#builderPopover').popover('show')
                .on('shown.bs.popover', function () {
                    $('.popover').last().addClass('popover-dark')
                });

            $(document).on('click', '#closeBuilderPopover', function () {
                window.localStorage.setItem('hs-builder-popover', true);
                $('#builderPopover').popover('dispose');
            });
        } else {
            $('#builderPopover').on('show.bs.popover', function () {
                return false
            });
        }

        // END ONLY DEV
        // =======================================================


        // BUILDER TOGGLE INVOKER
        // =======================================================
        $('.js-navbar-vertical-aside-toggle-invoker').click(function () {
            $('.js-navbar-vertical-aside-toggle-invoker i').tooltip('hide');
        });


        // INITIALIZATION OF MEGA MENU
        // =======================================================
        var megaMenu = new HSMegaMenu($('.js-mega-menu'), {
            desktop: {
                position: 'left'
            }
        }).init();


        // INITIALIZATION OF NAVBAR VERTICAL NAVIGATION
        // =======================================================
        var sidebar = $('.js-navbar-vertical-aside').hsSideNav();


        // INITIALIZATION OF TOOLTIP IN NAVBAR VERTICAL MENU
        // =======================================================
        $('.js-nav-tooltip-link').tooltip({boundary: 'window'})

        $(".js-nav-tooltip-link").on("show.bs.tooltip", function (e) {
            if (!$("body").hasClass("navbar-vertical-aside-mini-mode")) {
                return false;
            }
        });


        // INITIALIZATION OF UNFOLD
        // =======================================================
        $('.js-hs-unfold-invoker').each(function () {
            var unfold = new HSUnfold($(this)).init();
        });


        // INITIALIZATION OF FORM SEARCH
        // =======================================================
        $('.js-form-search').each(function () {
            new HSFormSearch($(this)).init()
        });


        // INITIALIZATION OF SELECT2
        // =======================================================
        $('.js-select2-custom').each(function () {
            var select2 = $.HSCore.components.HSSelect2.init($(this));
        });
    });
</script>

@yield('javascriptForm')
<!-- IE Support -->
<script>
    if (/MSIE \d|Trident.*rv:/.test(navigator.userAgent)) document.write('<script src="./assets/vendor/babel-polyfill/polyfill.min.js"><\/script>');
</script>
</body>
</html>
