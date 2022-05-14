<!-- BEGIN TOP BAR -->
<div class="pre-header">
    <div class="container">
        <div class="row">
            <!-- BEGIN TOP BAR LEFT PART -->
            <div class="col-md-6 col-sm-6 additional-shop-info">
                <ul class="list-unstyled list-inline">
                    <li><i class="fa fa-phone"></i><a href="tel:0362335462">0362335462</a></li>
                </ul>
            </div>
            <!-- END TOP BAR LEFT PART -->
            <!-- BEGIN TOP BAR MENU -->
            <div class="col-md-6 col-sm-6 additional-nav">
                <ul class="list-unstyled list-inline pull-right">
                    <li><a href="page-login.html">Đăng nhập</a></li>
                </ul>
            </div>
            <!-- END TOP BAR MENU -->
        </div>
    </div>
</div>
<!-- END TOP BAR -->

<!-- BEGIN HEADER -->
<div class="header">
    <div class="container">
        <a class="site-logo" href="{{asset('')}}"><img src="{{asset('')}}Account/theme/assets/corporate/img/logos/thinkpro.jpg" alt="Metronic Shop UI"></a>

        <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>

        <!-- BEGIN CART -->
        <div class="top-cart-block">
            <div class="top-cart-info">
                <a href="{{asset('')}}cart" class="top-cart-info-count">@{{lengthCart}} Sản phẩm</a>
            </div>
            <i class="fa fa-shopping-cart"></i>

            <div class="top-cart-content-wrapper">
                <div class="top-cart-content">
                    <ul class="scroller" style="height: 250px;">
                        <li ng-repeat="val in cart">
                            <a href="{{asset('')}}product/@{{ val.product.id }}"><img ng-src="{{asset('')}}@{{ val.product.image_path }}" alt="@{{val.product.name}}" width="37" height="34"></a>
                            <span class="cart-content-count">x @{{val.quality}}</span>
                            <strong><a href="{{asset('')}}product/@{{ val.product.id }}">@{{val.product.name}}</a></strong>
                            <a ng-click="deleteCart(val.product.id,val.option.id)" style="cursor: pointer" class="del-goods">&nbsp;</a>
                        </li>
                    </ul>
                    <div class="text-right">
                        <a href="{{asset('')}}cart" class="btn btn-primary">Xem giỏ hàng</a>
                    </div>
                </div>
            </div>
        </div>
        <!--END CART -->

        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation">
            <ul>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="javascript:;">
                        Thương hiệu
                    </a>

                    <!-- BEGIN DROPDOWN MENU -->
                    <ul class="dropdown-menu">
                        <li><a ng-click="searchTrademark(0)" style="cursor: pointer">Tất cả sản phẩm</a></li>
                    @foreach($trademarks as $trademark)
                            <li><a ng-click="searchTrademark({{$trademark->id}})" style="cursor: pointer">{{$trademark->name}} <img class="trademark-image" src="{{asset('')}}{{$trademark->image_path}}"> </a></li>
                        @endforeach
                    </ul>
                    <!-- END DROPDOWN MENU -->
                </li>
                <!-- BEGIN TOP SEARCH -->
                <li style="max-width: 300px; margin-left: 20px;" class="menu-search">
                    <div class="input-group">
                        <input type="text" ng-model="search" placeholder="Tìm sản phẩm" class="form-control">
                        <span class="input-group-btn">
                            <a class="btn btn-primary">Search</a>
                        </span>
                    </div>
                </li>
                <!-- END TOP SEARCH -->
            </ul>
        </div>
        <!-- END NAVIGATION -->
    </div>
</div>
<!-- Header END -->
