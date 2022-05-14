@extends('layouts.admin')

@section('title')
    <title>Danh mục sản phẩm</title>
@endsection

@section('javascriptForm')
    <script src="{{ asset('app\lib\angular.min.js')}}"></script>
    <script src="{{ asset('app\app.js')}}"></script>
    <script src="{{ asset('app\controller\admin\categoryController.js')}}"></script>
    <script src="{{ asset('app\message.js')}}"></script>
    <script>
        var isFormValid = true;
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
                blurs.onblur = function(){
                    if(index == 0){
                        function tests(){
                            return input[0].value.trim().length >= 1 ? undefined :  `Hãy nhập tên danh mục`;
                        }
                        if(tests() == null){
                        }
                        else{
                            var mess = tests();
                            add__blur(input[0].parentElement,mess);
                        }
                    }
                }
                blurs.oninput = function(){
                    if(index == 0){
                        remove_oninput(input[0].parentElement);
                        isFormValid = true;
                    }
                }
            })
            const submit = document.querySelector('.auth-form__submit');
            submit.onclick = function(){
                for(var i = 0; i < input.length;i++){
                    if(i == 0){
                        function tests(){
                            return input[0].value.trim().length >= 1 ? undefined :  `Hãy nhập tên danh mục`;
                        }
                        if(tests() == null){
                        }
                        else{
                            var mess = tests();
                            add__blur(input[0].parentElement,mess);
                            isFormValid = false;
                        }
                    }
                }
                if(isFormValid == true){

                }
            }
        });
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
                        <h1 class="page-header-title">Danh mục sản phẩm <span class="badge badge-soft-dark ml-2">@{{ amount }}</span></h1>
                    </div>

                    <div class="col-sm-auto">
                        <a class="btn btn-primary" ng-click="modal('add')"  data-toggle="modal" data-target="#exampleModal1">Thêm danh mục</a>
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
                            <th title="Click để sắp xếp" style="cursor: pointer" scope="col" ng-click="sort('name')">Tên danh mục
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
                                    @{{val.created_at | date:'yyyy-MM-dd HH:mm:ss'}}
                                </h5>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-sm btn-white" ng-click="modal('edit',val.id)" data-toggle="modal" data-target="#exampleModal1">
                                        <i class="tio-edit"></i> Edit
                                    </a>
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
                                <label for="NameCategory" class="input-label">Tên danh mục</label>
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control auth-form__input" ng-model="categories.name" placeholder="Nhập tên danh mục">
                                    <span class="form-message"></span>
                                </div>
                            </div>
                            <!-- End Input Group -->

                            <!-- Input Group -->
                            <div class="form-group">
                                <label for="parent_id" class="input-label">Danh mục cha</label>
                                <div class="input-group input-group-merge">
                                    <select id="parent_idSelect" class="custom-select auth-form__input">
                                    </select>
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
                            Bạn có chắc chắn muốn xoá danh mục "@{{name}}"
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
