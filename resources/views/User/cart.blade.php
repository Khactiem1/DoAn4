@extends('layouts.user')

@section('title')
    <title>Giỏ hàng</title>
@endsection

@section('cssLink')
    {{--    <link rel="stylesheet" href="{{ asset('app\lib\dropzone.css')}}" />--}}
@endsection

@section('css')
    .code-apply span{
        padding: 6px;
        border: solid 1px #ccc;
        margin-right: 3px;
        display: inline-block;
        margin-top: 6px;
    }
@endsection

@section('javascriptForm')
    <script src="{{ asset('app\lib\angular.min.js')}}"></script>
    <script src="{{ asset('app\user.js')}}"></script>
    <script src="{{ asset('app\controller\user\cartController.js')}}"></script>
    <script src="{{ asset('app\message.js')}}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            Layout.init();
            Layout.initOWL();
            Layout.initImageZoom();
            Layout.initTouchspin();
            Layout.initNavScrolling();
        });
    </script>
@endsection

@section('content')
    <div class="main">
        <div class="container">
            <!-- BEGIN SIDEBAR & CONTENT -->
            <div class="row margin-bottom-40">
                <!-- BEGIN CONTENT -->
                <div class="col-md-12 col-sm-12">
                    <h1 style="text-transform: none;">Giỏ hàng của bạn</h1>
                    <div class="goods-page">
                        <div class="goods-data clearfix">
                            <div class="table-wrapper-responsive">
                                <table summary="Shopping cart">
                                    <tr>
                                        <th class="goods-page-image">Hình ảnh</th>
                                        <th class="goods-page-description">Sản phẩm</th>
                                        <th class="goods-page-quantity">Số lượng</th>
                                        <th class="goods-page-price">Giá</th>
                                        <th class="goods-page-total" colspan="2">Tổng</th>
                                    </tr>
                                    <tr ng-repeat="val in cart">
                                        <td class="goods-page-image">
                                            <a href="{{asset('')}}product/@{{ val.product.id }}"><img ng-src="{{asset('')}}@{{ val.product.image_path }}" alt="@{{val.product.name}}"></a>
                                        </td>
                                        <td class="goods-page-description">
                                            <h3><a href="{{asset('')}}product/@{{ val.product.id }}">@{{ val.product.name }}</a></h3>
                                            <div class="option-content">
                                                @{{val.option.CPU + ' - ' + val.option.RAM + ' - ' + val.option.ROM + ' - '+val.option.VGA + ' - ' + val.option.display}}
                                                <p>- @{{ val.product.promotion }}</p>
                                            </div>
                                            <div class="option-color">
                                                Màu:
                                                <span style="background-color: @{{val.option.color}};" class="option-color-view">
                                            </span>
                                            </div>
                                        </td>
                                        <td class="goods-page-quantity">
                                            <div class="product-quantity">
                                                <input id="product-quantity" type="text" value="@{{ val.quality}}" readonly class="form-control input-sm">
                                                <span class="input-group-btn"><div ng-click="cartUp(val.product.id,val.option.id)" class="btn quantity-up bootstrap-touchspin-up"><i class="fa fa-angle-up"></i></div></span>
                                                <span class="input-group-btn"><div ng-click="cartDown(val.product.id,val.option.id)" class="btn quantity-down bootstrap-touchspin-down"><i class="fa fa-angle-down"></i></div></span>
                                            </div>
                                        </td>
                                        <td class="goods-page-price">
                                            <strong>@{{ val.option.price_sale | number : fractionSize}}<span>đ</span></strong>
                                        </td>
                                        <td class="goods-page-total">
                                            <strong>@{{ val.option.price_sale *  val.quality | number : fractionSize}}<span>đ</span></strong>
                                        </td>
                                        <td class="del-goods-col">
                                            <a class="del-goods" ng-click="deleteCart(val.product.id,val.option.id)" style="cursor: pointer;">&nbsp;</a>
                                        </td>
                                    </tr>

                                </table>
                            </div>

                            <div class="shopping-total">
                                <div style="margin-bottom: 8px;" class="code">
                                    <div class="input-group">
                                        <input type="text" ng-model="searchCode" placeholder="Nhập mã giảm giá" class="form-control">
                                        <span class="input-group-btn">
                                            <a style="margin: 0; color: #fff; text-transform: none;" ng-click="applyCode()" class="btn btn-primary">Áp dụng</a>
                                        </span>
                                    </div>
                                    <div class="code-apply">
                                        <span ng-repeat="val in codes">
                                            @{{val.code}} <a ng-click="deleteCode(val.id)" style="cursor: pointer;">x</a>
                                        </span>
                                    </div>
                                </div>
                                <ul>
                                    <li>
                                        <em style="text-transform: none;">Tổng tiền</em>
                                        <strong class="price">@{{total | number : fractionSize}}<span>đ</span></strong>
                                    </li>
                                    <li>
                                        <em style="text-transform: none;">Giảm giá</em>
                                        <strong class="price">@{{sale | number : fractionSize}}<span>đ</span></strong>
                                    </li>
                                    <li class="shopping-total-price">
                                        <em style="text-transform: none;">Thành tiền</em>
                                        <strong class="price">@{{total - sale | number : fractionSize}}<span>đ</span></strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <a href="{{asset('')}}" class="btn btn-default">Tiếp tục mua hàng <i class="fa fa-shopping-cart"></i></a>
                        <a href="#" class="btn btn-primary">Đặt hàng <i class="fa fa-check"></i></a>
                    </div>
                </div>
                <!-- END CONTENT -->
            </div>
            <!-- END SIDEBAR & CONTENT -->
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
        </div>
    </div>
@endsection
