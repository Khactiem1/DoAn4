<!-- BEGIN SIDEBAR -->
<div class="sidebar col-md-3 col-sm-4">
    <ul class="list-group margin-bottom-25 sidebar-menu">
        <li style="background-color: #f9f9f9" class="list-group-item clearfix"><span style="text-transform: none;font-size: 20px;">Danh mục sản phẩm</span></li>
        {!! $htmlCategory !!}
    </ul>

    <div class="sidebar-filter margin-bottom-25">
        <h3>Giá</h3>
        <p>
            <label for="amount">Chọn mức giá:</label>
            <div style="margin-top: 25px;" class="range-price">
                <input class="range-slider" type="hidden" value="10,100"/>
            </div>
            <a class="btn btn-primary" ng-click="searchPrice()" style="color: #fff; margin-top: 30px;">Search</a>
        </p>
    </div>
</div>
<!-- END SIDEBAR -->
