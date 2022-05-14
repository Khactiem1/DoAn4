@extends('layouts.user')

@section('title')
    <title>{{$product->name}}</title>
@endsection

@section('cssLink')
    {{--    <link rel="stylesheet" href="{{ asset('app\lib\dropzone.css')}}" />--}}
@endsection

@section('css')

@endsection

@section('javascriptForm')
    <script src="{{ asset('app\lib\angular.min.js')}}"></script>
    <script src="{{ asset('app\user.js')}}"></script>
    <script src="{{ asset('app\controller\user\detailProductController.js')}}"></script>
    <script src="{{ asset('app\message.js')}}"></script>
    <script type="text/javascript">
        let op1 = {{$product->options[0]->price_sale}};
        let op2 = {{$product->options[0]->price}};
        let op = {{$product->options[0]->id}};
        jQuery(document).ready(function() {
            Layout.init();
            Layout.initOWL();
            Layout.initTwitter();
            Layout.initImageZoom();
            Layout.initTouchspin();
            Layout.initUniform();
            Layout.initFixHeaderWithPreHeader();
        });
    </script>
@endsection

@section('content')
    <div class="main">
        <div class="container">
            <!-- BEGIN SIDEBAR & CONTENT -->
            <!-- BEGIN CONTENT -->
            <div class="col-md-12 col-sm-12">
                <div class="product-page">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="product-main-image">
                                <img src="{{asset('')}}{{$product->image_path}}" alt="">
                            </div>
                            <div class="product-other-images">
                                @foreach($product->images as $image)
                                    <a href="{{asset('')}}{{$image->image_path}}" class="fancybox-button" rel="photos-lib"><img style="border: solid 1px #ccc;" alt="Berry Lace Dress" src="{{asset('')}}{{$image->image_path}}"></a>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <h1>{{$product->name}}</h1>
                            <div class="price-availability-block clearfix">
                                <div class="price">
                                    <strong id="pr1">@{{priceSale | number : fractionSize}}<span>đ</span></strong>&ensp;
                                    <em><span id="pr2">@{{price | number : fractionSize}}</span>đ</em>
                                </div>
                            </div>
                            <div class="product-page-cart">
                                <span class="none">{{$op = 'active'}}</span>
                                @foreach($product->options as $option)
                                    <div ng-click="changeOption({{$option->id}})" class="option {{$op}} option{{$option->id}}">
                                        <div class="option-content">
                                            {{$option->CPU.' - '.$option->RAM.' - '.$option->ROM.' - '.$option->VGA.' - '.$option->display}}
                                        </div>
                                        <div class="option-price">
                                            {{number_format($option->price_sale)}} đ &ensp; <span>{{number_format($option->price)}} đ</span>
                                        </div>
                                        <div class="option-color">
                                            Màu:
                                            <span style="background-color: {{$option->color}};" class="option-color-view">
                                            </span>
                                        </div>
                                    </div>
                                    <span class="none">{{$op=''}}</span>
                                @endforeach
                            </div>
                            <div class="product-page-cart">
                                <h2 style="text-transform: none">Quà tặng:</h2>
                                {{$product->promotion}}
                            </div>
                            <div class="product-page-cart">
                                <button class="btn btn-primary" ng-click="addCard({{$product->id}})">Thêm vào giỏ</button>
                            </div>
                        </div>

                        <div class="product-page-content">
                            <hr style="margin-top: 50px;">
                            <h1 style="color: #e94d1c">Thông tin sản phẩm</h1>
                            <div class="tab-pane">
                                <table class="datasheet">
                                    <tr>
                                        <td class="datasheet-features-type">Kết nối chính</td>
                                        <td>{{$product->connect}}</td>
                                    </tr>
                                    <tr>
                                        <td class="datasheet-features-type">Trọng lượng</td>
                                        <td>{{$product->weight}}</td>
                                    </tr>
                                    <tr>
                                        <td class="datasheet-features-type">Pin</td>
                                        <td>{{$product->battery}}</td>
                                    </tr>
                                    <tr>
                                        <td class="datasheet-features-type">Thương hiệu</td>
                                        <td>{{$product->trademark->name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="datasheet-features-type">Hạng mục</td>
                                        <td>{{$product->category->name}}</td>
                                    </tr>
                                    <tr>
                                        <td class="datasheet-features-type">Quà tặng</td>
                                        <td>{{$product->promotion}}</td>
                                    </tr>
                                </table>
                            </div>
                            <hr style="margin-top: 50px;">
                            <h1 style="color: #e94d1c ">Mô tả</h1>
                            <div class="tab-pane">
                                {!! $product->description !!}
                            </div>
                            <hr style="margin-top: 50px;">
                            <h1 style="color: #e94d1c ">Đánh giá</h1>
                            <div class="tab-pane">
                                <!--<p>There are no reviews for this product.</p>-->
                                <div class="review-item clearfix">
                                    <div class="review-item-submitted">
                                        <img style="width: 40px;" src="http://localhost:8000/storeImage/product/productMain/1652082627.png" alt="">
                                        <strong style="margin-left: 6px;">Bob</strong>
                                        <em>30/12/2013 - 07:37</em>
                                    </div>
                                    <div class="review-item-content">
                                        <p>Sed velit quam, auctor id semper a, hendrerit eget justo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Duis vel arcu pulvinar dolor tempus feugiat id in orci. Phasellus sed erat leo. Donec luctus, justo eget ultricies tristique, enim mauris bibendum orci, a sodales lectus purus ut lorem.</p>
                                    </div>
                                </div>
                                <!-- BEGIN FORM-->
                                <div class="reviews-form">
                                    <h2>Viết đánh giá</h2>
                                    <div class="form-group">
                                        <label for="review">Đánh giá <span class="require">*</span></label>
                                        <textarea class="form-control" rows="8" id="review"></textarea>
                                    </div>
                                    <div class="padding-top-20">
                                        <button class="btn btn-primary">Gửi</button>
                                    </div>
                                </div>
                                <!-- END FORM-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
            <!-- BEGIN SALE PRODUCT & NEW ARRIVALS -->
            <div class="row margin-bottom-40">
                <!-- BEGIN SALE PRODUCT -->
                <div class="col-md-12 sale-product">
                    <h2 style="margin-top: 40px;text-transform: none;">Sản phẩm tương tự</h2>
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
        </div>
    </div>
@endsection
