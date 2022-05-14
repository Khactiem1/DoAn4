@extends('layouts.user')

@section('title')
    <title>ThinkPro cửa hàng laptop uy tín số một Việt Nam</title>
@endsection

@section('cssLink')
{{--    <link rel="stylesheet" href="{{ asset('app\lib\dropzone.css')}}" />--}}
@endsection

@section('css')
    #google-map{
        width: 100%;
    }
@endsection

@section('javascriptForm')
    <script src="{{ asset('app\lib\angular.min.js')}}"></script>
    <script src="{{ asset('app\user.js')}}"></script>
    <script src="{{ asset('app\controller\user\homeController.js')}}"></script>
    <script src="{{ asset('app\message.js')}}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            Layout.init();
            Layout.initOWL();
            Layout.initImageZoom();
            Layout.initTouchspin();
            //Layout.initTwitter();

            Layout.initFixHeaderWithPreHeader();
            Layout.initNavScrolling();
            $(document).ready(function(){
                $('.range-slider').jRange({
                    from: 0,
                    to: 100,
                    step: 1,
                    scale: [0,25,50,75,100],
                    format: '%s',
                    width: 232,
                    showLabels: true,
                    isRange : true
                });
            });
        });
    </script>
@endsection

@section('content')
    @include('partials.User.slider')
    <div class="main">
        <div class="container">
            <!-- BEGIN SALE PRODUCT & NEW ARRIVALS -->
            <div class="row margin-bottom-40">
                <!-- BEGIN SALE PRODUCT -->
                <div class="col-md-12 sale-product">
                    <h2>Sản phẩm nổi bật</h2>
                    <div class="owl-carousel owl-carousel5">
                        @foreach($products as $product)
                            <div>
                                <div class="product-item">
                                    <div class="pi-img-wrapper">
                                        <img src="{{asset('')}}{{ $product->image_path }}" class="img-responsive" alt="Berry Lace Dress">
                                        <div>
                                            <a href="{{asset('')}}product/{{$product->id}}" class="btn btn-default">Chi tiết</a>
                                        </div>
                                    </div>
                                    <h3><a style="text-transform: none;height: 55px; display: block;" href="{{asset('')}}product/{{$product->id}}">{{ $product->name }}</a></h3>
                                    <div class="pi-price">{{number_format($product->options[0]->price_sale)}} đ &ensp; <span style="text-decoration-line:line-through; color: #ccc">{{number_format($product->options[0]->price)}} đ</span></div>
                                    <a class="btn btn-default add2cart"ng-click="addCard({{$product->id}},{{$product->options[0]->id}})">Thêm giỏ hàng</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- END SALE PRODUCT -->
            </div>
            <!-- END SALE PRODUCT & NEW ARRIVALS -->

            <!-- BEGIN SIDEBAR & CONTENT -->
            <div class="row margin-bottom-40 ">
                @include('partials.User.siderbar')
                <!-- BEGIN CONTENT -->
                <div class="col-md-9 col-sm-8">
                    <h2 style="text-transform: none;font-size: 20px; line-height: 32px;">Sản phẩm</h2>
                    <div id="loadSearch" class="col-md-4 col-sm-6 col-xs-12 none">
                        <div class="product-item">
                            <div class="pi-img-wrapper">
                                <div>
                                </div>
                            </div>
                            <h3><a style="text-transform: none;height: 55px; display: block;">Loading...</a></h3>
                        </div>
                    </div>
                    <div dir-paginate="val in data|orderBy:sortKey:reverse|filter:search|itemsPerPage:15" class="col-md-4 col-sm-6 col-xs-12">
                        <div class="product-item">
                            <div class="pi-img-wrapper">
                                <img ng-src="{{asset('')}}@{{ val.image_path }}" class="img-responsive" alt="Berry Lace Dress">
                                <div>
                                    <a href="{{asset('')}}product/@{{val.id}}" class="btn btn-default">Chi tiết</a>
                                </div>
                            </div>
                            <h3><a style="text-transform: none;height: 55px; display: block;"  href="{{asset('')}}product/@{{val.id}}">@{{val.name}}</a></h3>
                            <div class="pi-price">@{{val.options[0].price_sale | number : fractionSize}} đ &ensp; <span style="text-decoration-line:line-through; color: #ccc">@{{val.options[0].price | number : fractionSize}} đ</span></div>
                            <a class="btn btn-default add2cart" ng-click="addCard(val.id,val.options[0].id)">Thêm giỏ hàng</a>
                        </div>
                    </div>
                </div>
                <!-- END CONTENT -->
            </div>
            <!-- END SIDEBAR & CONTENT -->
            <!-- Pagination -->
            <div class="row justify-content-center justify-content-sm-between align-items-sm-center">
                <div style="display: flex; justify-content: right" class="col-sm mb-2 mb-sm-0">
                    <dir-pagination-controls
                        max-size="5"
                        direction-links="true"
                        boundary-links="true" >
                    </dir-pagination-controls>
                </div>

                <div class="col-sm-auto">
                    <div class="d-flex justify-content-center justify-content-sm-end">
                        <!-- Pagination -->
                        <nav id="datatablePagination" aria-label="Activity pagination"></nav>
                    </div>
                </div>
            </div>
            <!-- End Pagination -->

            <!-- BEGIN SALE PRODUCT & NEW ARRIVALS -->
            <div class="row margin-bottom-40">
                <!-- BEGIN SALE PRODUCT -->
                <div class="col-md-12 sale-product">
                    <h2 style="text-transform: none;">Sản phẩm được quan tâm nhiều nhất</h2>
                    <div class="owl-carousel owl-carousel5">
                        @foreach($productComment as $product)
                            <div>
                                <div class="product-item">
                                    <div class="pi-img-wrapper">
                                        <img src="{{asset('')}}{{ $product->image_path }}" class="img-responsive" alt="Berry Lace Dress">
                                        <div>
                                            <a href="{{asset('')}}product/{{$product->id}}" class="btn btn-default">Chi tiết</a>
                                        </div>
                                    </div>
                                    <h3><a style="text-transform: none;height: 55px; display: block;" href="{{asset('')}}product/{{$product->id}}">{{ $product->name }}</a></h3>
                                    <div class="pi-price">{{number_format($product->options[0]->price_sale)}} đ &ensp; <span style="text-decoration-line:line-through; color: #ccc">{{number_format($product->options[0]->price)}} đ</span></div>
                                    <a class="btn btn-default add2cart"ng-click="addCard({{$product->id}},{{$product->options[0]->id}})">Thêm giỏ hàng</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- END SALE PRODUCT -->
            </div>
            <!-- END SALE PRODUCT & NEW ARRIVALS -->
            <div class="row margin-bottom-40">
                <div class="col-md-12">
                    <h2 style="text-transform: none;">Địa chỉ cửa hàng</h2>
                    <iframe id="google-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2030.8132932444946!2d105.8210700738781!3d21.011552282331234!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135abdf7994930d%3A0x9766da564d2b294b!2sThinkPro!5e0!3m2!1svi!2sus!4v1652419545424!5m2!1svi!2sus" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
