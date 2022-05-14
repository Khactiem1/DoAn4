@extends('layouts.admin')

@section('title')
    <title>Quản lí mã giảm giá</title>
@endsection

@section('javascriptForm')
    <script src="{{ asset('app\lib\angular.min.js')}}"></script>
    <script src="{{ asset('app\app.js')}}"></script>
    <script src="{{ asset('app\controller\admin\discountController.js')}}"></script>
    <script src="{{ asset('app\message.js')}}"></script>
    <script>
        var isFormValid = true;
        let stateApply = 0;
        $(document).on('ready', function () {
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
                blurs.oninput = function(){
                    remove_oninput(input[index].parentElement);
                    isFormValid = true;
                }
            })
            const submit = document.querySelector('.auth-form__submit');
            submit.onclick = function(){
                if(input[6].value.trim() != ''){
                    remove_oninput(input[6].parentElement);
                    isFormValid = true;
                }
                for(var i = 0; i < input.length;i++){
                    if(stateApply == 1 && i == 2){
                        function tests(){
                            return input[i].value.length >= 1 ? undefined :  `Hãy nhập trường này`;
                        }
                        if(tests() == null){
                        }
                        else{
                            var mess = tests();
                            add__blur(input[i].parentElement,mess);
                            isFormValid = false;
                        }
                    }
                    if(stateApply == 2 && i == 3){
                        function tests(){
                            return input[i].value.length >= 1 ? undefined :  `Hãy nhập trường này`;
                        }
                        if(tests() == null){
                        }
                        else{
                            var mess = tests();
                            add__blur(input[i].parentElement,mess);
                            isFormValid = false;
                        }
                    }
                    if(document.getElementById('option-quantity').value == 0 && i ==5){
                        function tests(){
                            return input[i].value.trim().length >= 1 ? undefined :  `Hãy nhập trường này`;
                        }
                        if(tests() == null){
                        }
                        else{
                            var mess = tests();
                            add__blur(input[i].parentElement,mess);
                            isFormValid = false;
                        }
                    }
                    if(document.getElementById('option-date').value == 0 && i ==6){
                        function tests(){
                            return input[i].value.trim().length >= 1 ? undefined :  `Hãy nhập trường này`;
                        }
                        if(tests() == null){
                        }
                        else{
                            var mess = tests();
                            add__blur(input[i].parentElement,mess);
                            isFormValid = false;
                        }
                    }
                    if(i != 2 && i != 3 && i != 5 && i != 6){
                        function tests(){
                            return input[i].value.trim().length >= 1 ? undefined :  `Hãy nhập trường này`;
                        }
                        if(tests() == null){
                        }
                        else{
                            var mess = tests();
                            add__blur(input[i].parentElement,mess);
                            isFormValid = false;
                        }
                    }
                }
                if(isFormValid == true){

                }
            }




            $.HSCore.components.HSDaterangepicker.init($('.js-daterangepicker-times'), {
                startDate: moment().startOf('hour'),
                endDate: moment().startOf('hour').add(32, 'hour')
            });
        });
        $(document).on('input', '.inputPrice', function(){
            setPriceFormat(this);
        });
        function setPriceFormat(inputElement){
            let val = inputElement.value;
            let elm = inputElement.parentElement.parentElement;
            let name =  elm.querySelector('.inputPriceScreen');
            name.innerText = Number(val).toLocaleString("en");
        }
    </script>

@endsection

@section('content')
    <div ng-app="my-app">
        <!-- Content -->
        <div class="content container-fluid" ng-controller="categoryController">
            <!-- Page Header -->
            <div>
                <div class="row align-items-center mb-3">
                    <div class="col-sm mb-2 mb-sm-0">
                        <h1 class="page-header-title">Mã giảm giá <span class="badge badge-soft-dark ml-2">@{{ amount }}</span></h1>
                    </div>

                    <div class="col-sm-auto">
                        <a class="btn btn-primary" ng-click="modal('add')"  data-toggle="modal" data-target="#exampleModal1">Thêm mã giảm giá</a>
                    </div>
                </div>
                <!-- End Row -->
            </div>
            <!-- End Page Header -->
            <!-- End Row -->

            <!-- Card -->
            <div style="overflow-x: auto" class="card">
                <!-- Header -->
                <div class="card-header">
                    <div class="row justify-content-between align-items-center flex-grow-1">
                        <div class="mb-3 mb-md-0">
                            <form>
                                <!-- Search -->
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tio-search"></i>
                                        </div>
                                    </div>
                                    <input style="min-width: 200px;" type="search" class="form-control" ng-model="search" placeholder="Tìm kiếm" >
                                    <select ng-model="page.unit"
                                            id="pageInit"
                                            ng-change="changePage()"
                                            class="custom-select">
                                        <option ng-repeat="item in pages" ng-value="item.id">@{{item.label}}</option>
                                    </select>
                                </div>
                                <!-- End Search -->
                            </form>
                        </div>
                    </div>
                    <!-- End Row -->
                </div>
                <!-- End Header -->
                <!-- Table -->
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">STT</th>
                        <th title="Click để sắp xếp" style="cursor: pointer" scope="col" ng-click="sort('name')">Tên chương trình
                            <span class="glyphicon sort-icon" ng-show="sortKey=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                        </th>
                        <th title="Click để sắp xếp" style="cursor: pointer" scope="col" ng-click="sort('name')">Mã giảm giá
                            <span class="glyphicon sort-icon" ng-show="sortKey=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                        </th>
                        <th title="Click để sắp xếp" style="cursor: pointer" scope="col" ng-click="sort('name')">Áp dụng cho
                            <span class="glyphicon sort-icon" ng-show="sortKey=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                        </th>
                        <th title="Click để sắp xếp" style="cursor: pointer" scope="col" ng-click="sort('name')">Mức giảm
                            <span class="glyphicon sort-icon" ng-show="sortKey=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                        </th>
                        <th title="Click để sắp xếp" style="cursor: pointer" scope="col" ng-click="sort('created_at')">Số lượng
                            <span class="glyphicon sort-icon" ng-show="sortKey=='created_at'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                        </th>
                        <th title="Click để sắp xếp" style="cursor: pointer" scope="col" ng-click="sort('name')">Thời gian
                            <span class="glyphicon sort-icon" ng-show="sortKey=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                        </th>
                        <th title="Click để sắp xếp" style="cursor: pointer" scope="col" ng-click="sort('created_at')">Ngày tạo
                            <span class="glyphicon sort-icon" ng-show="sortKey=='created_at'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                        </th>
                        <th scope="col">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr dir-paginate="val in data|orderBy:sortKey:reverse|filter:search|itemsPerPage:page.unit">
                        <td style="vertical-align: middle;">
                            <h5 class="text-hover-primary mb-0">
                                @{{$index + 1}}
                            </h5>
                        </td>
                        <td style="min-width: 300px;vertical-align: middle;">
                            <h5 class="text-hover-primary mb-0">
                                @{{val.name}}
                            </h5>
                        </td>
                        <td style="vertical-align: middle;">
                            <h5 class="text-hover-primary mb-0">
                                @{{val.code}}
                            </h5>
                        </td>
                        <td style="vertical-align: middle;">
                            <h5 class="text-hover-primary mb-0">
                                @{{val.stateApply}}
                            </h5>
                        </td>
                        <td style="vertical-align: middle;">
                            <h5 class="text-hover-primary mb-0">
                                @{{val.optionPrice}}
                            </h5>
                        </td>
                        <td style="vertical-align: middle;">
                            <h5 class="text-hover-primary mb-0">
                                @{{val.optionQuantity}}
                            </h5>
                        </td>
                        <td style="vertical-align: middle;">
                            <h5 class="text-hover-primary mb-0">
                                @{{val.optionDate}}
                            </h5>
                        </td>
                        <td style="vertical-align: middle;">
                            <h5 class="text-hover-primary mb-0">
                                @{{val.created_at | date:'yyyy-MM-dd HH:mm:ss'}}
                            </h5>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a class="btn btn-sm btn-white" ng-click="modal('delete',val.id,val.name)" data-toggle="modal" data-target="#exampleModal2">
                                    <i class="tio-delete-outlined dropdown-item-icon"></i> Delete
                                </a>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <!-- End Table -->
                <!-- Footer -->
                <div class="card-footer">
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
                </div>
                <!-- End Footer -->
            </div>
            <!-- End Card -->
            <!-- Modal1 -->
            <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">@{{frmTitle}}</h5>
                            <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
                                <i class="tio-clear tio-lg"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Input Group -->
                            <div class="form-group">
                                <label for="NameCategory" class="input-label">Tên chương trình</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control auth-form__input" ng-model="discount.name" placeholder="Nhập tên chương trình">
                                    <span class="form-message"></span>
                                </div>
                            </div>
                            <!-- End Input Group -->

                            <!-- Input Group -->
                            <div class="form-group">
                                <label for="parent_id" class="input-label">Mã giảm giá</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control auth-form__input" ng-model="discount.code" placeholder="Nhập mã giảm giá">
                                    <span class="form-message"></span>
                                </div>
                            </div>
                            <!-- End Input Group -->
                            <!-- Input Group -->
                            <div class="form-group">
                                <label for="parent_id" class="input-label">Áp dụng cho</label>
                                <!-- Nav -->
                                <div class="text-center">
                                    <ul class="nav nav-segment nav-pills mb-4" role="tablist">
                                        <li class="nav-item">
                                            <a ng-click="stateApply('0')" class="nav-link active" id="nav-one-eg1-tab" data-toggle="pill" href="#nav-one-eg1" role="tab" aria-controls="nav-one-eg1" aria-selected="true">Tất cả sản phẩm</a>
                                        </li>
                                        <li class="nav-item">
                                            <a ng-click="stateApply('1')" class="nav-link" id="nav-two-eg1-tab" data-toggle="pill" href="#nav-two-eg1" role="tab" aria-controls="nav-two-eg1" aria-selected="false">Thương hiệu</a>
                                        </li>
                                        <li class="nav-item">
                                            <a ng-click="stateApply('2')" class="nav-link" id="nav-three-eg1-tab" data-toggle="pill" href="#nav-three-eg1" role="tab" aria-controls="nav-three-eg1" aria-selected="false">Nhóm sản phẩm</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End Nav -->

                                <!-- Tab Content -->
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="nav-one-eg1" role="tabpanel" aria-labelledby="nav-one-eg1-tab">
                                    </div>

                                    <div class="tab-pane fade" id="nav-two-eg1" role="tabpanel" aria-labelledby="nav-two-eg1-tab">
                                        <div class="input-group input-group-merge">
                                            <!-- Select2 -->
                                            <select class="js-select2-custom custom-select form-control auth-form__input" ng-model="discount.trademarks" multiple size="1" style="opacity: 0;"
                                                    data-hs-select2-options='{
                                                      "minimumResultsForSearch": "Infinity"
                                                    }'>
                                                @foreach($trademarks as $trademark)
                                                    <option value="{{$trademark->id}}">{{$trademark->name}}</option>
                                                @endforeach
                                            </select>
                                            <!-- End Select2 -->
                                            <span class="form-message"></span>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="nav-three-eg1" role="tabpanel" aria-labelledby="nav-three-eg1-tab">
                                        <div class="input-group input-group-merge">
                                            <!-- Select2 -->
                                            <select class="js-select2-custom custom-select form-control auth-form__input" ng-model="discount.products" multiple size="1" style="opacity: 0;"
                                                    data-hs-select2-options='{
                                                      "minimumResultsForSearch": "Infinity"
                                                    }'>
                                                @foreach($products as $product)
                                                    <option value="{{$product->id}}">{{$product->name}}</option>
                                                @endforeach
                                            </select>
                                            <!-- End Select2 -->
                                            <span class="form-message"></span>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Tab Content -->
                            </div>
                            <!-- End Input Group -->

                            <!-- Input Group -->
                            <div class="form-group">
                                <label for="parent_id" class="input-label">Mức giảm <span style="margin-left: 6px;" class="inputPriceScreen"></span></label>
                                <div class="form-group input-group input-group-sm-down-break align-items-center">
                                    <input type="number" class="form-control auth-form__input inputPrice" ng-model="discount.price" placeholder="Mức giảm giá">
                                    <div class="input-group-append">
                                        <!-- Select -->
                                        <div class="select2-custom">
                                            <select id="option-price" class="custom-select" name="phoneSelect">
                                                <option value='0'>Giảm theo %</option>
                                                <option value='1'>Giảm theo số tiền</option>
                                            </select>
                                            <!-- End Select -->
                                        </div>
                                    </div>
                                    <span class="form-message"></span>
                                </div>
                            </div>
                            <!-- End Input Group -->

                            <!-- Input Group -->
                            <div class="form-group">
                                <label for="parent_id" class="input-label">Số lượng sản phẩm áp dụng</label>
                                <div class="form-group input-group input-group-sm-down-break align-items-center">
                                    <input type="text" class="form-control auth-form__input" ng-model="discount.quantity" placeholder="Số lượng sản phẩm áp dụng">
                                    <div class="input-group-append">
                                        <!-- Select -->
                                        <div class="select2-custom">
                                            <select id="option-quantity" class="custom-select" name="phoneSelect">
                                                <option value='0' selected>Số lượng sản phẩm</option>
                                                <option value='1'>Không giới hạn</option>
                                            </select>
                                            <!-- End Select -->
                                        </div>
                                    </div>
                                    <span class="form-message"></span>
                                </div>
                            </div>
                            <!-- End Input Group -->
                            <!-- Input Group -->
                            <div class="form-group">
                                <label for="parent_id" class="input-label">Ngày áp dụng</label>
                                <div class="form-group input-group input-group-sm-down-break align-items-center">
                                    <input type="text" ng-model="discount.date" class="js-daterangepicker-times form-control daterangepicker-custom-input auth-form__input"
                                           data-hs-daterangepicker-options='{
                                            "parentEl": "#exampleModal1",
                                             "timePicker": true,
                                             "locale": {
                                               "format": "M/DD/YYYY hh:mm A"
                                             }
                                    }'>
                                    <div class="input-group-append">
                                        <!-- Select -->
                                        <div class="select2-custom">
                                            <select id="option-date" class="custom-select" name="phoneSelect">
                                                <option value='0' selected>Áp dụng theo ngày</option>
                                                <option value='1'>Không giới hạn</option>
                                            </select>
                                            <!-- End Select -->
                                        </div>
                                    </div>
                                    <span class="form-message"></span>
                                </div>
                            </div>
                            <!-- End Input Group -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="closeForm1" class="btn btn-white" data-dismiss="modal">đóng</button>
                            <button type="button" class="btn btn-primary auth-form__submit" ng-click = "save(state,id)">
                                <span class="spinner-text">
                                    Lưu
                                </span>
                                <div class="loading">
                                    <span class="spinner-border spinner-border-sm"></span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->

            <!-- Modal2 -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">@{{ frmTitle }}</h5>
                            <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
                                <i class="tio-clear tio-lg"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            Bạn có chắc chắn muốn trương trình giảm giá "@{{name}}"
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="closeForm2" class="btn btn-white" data-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-primary auth-form__submit" ng-click = "save(state,id)">
                                <span class="spinner-text">
                                    Xoá
                                </span>
                                <div class="loading">
                                    <span class="spinner-border spinner-border-sm"></span>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal -->
        </div>
        <!-- End Content -->
    </div>
@endsection
