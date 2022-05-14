@extends('layouts.admin')

@section('title')
    <title>Quản lý sản phẩm</title>
@endsection

@section('css')
    #dropzoneForm,#dropzoneForm2{
        border-width: 1px;
        min-height: unset;
    }
    /*.tox.tox-tinymce{*/
    /*    height: 350px !important;*/
    /*}*/
    .inputColorScreen{
        padding: 1px 10px 1px 10px;
        border-radius: 5px;
        border: solid 1px #ccc;
    }
    .inputPriceScreen{
        color: #377dff;
    }
    .none{
        display: none;
    }
    .dz-button{
        outline: none;
        color: #fff;
        background-color: #00c9db;
        border: none;
        padding: 0.54688rem 0.875rem;
        border-radius: 0.3125rem;
    }
    .remove_image{
        white-space: nowrap;
    }
    .img-load{
        width: 120px !important;
        margin: 16px;
        margin-bottom: 0;
    }
    .img-load img{
        width: 120px !important;
        height: 120px !important;
    }
    .tox-notifications-container{
        display: none;
    }
@endsection

@section('cssLink')
    <link rel="stylesheet" href="{{ asset('app\lib\dropzone.css')}}" />
@endsection

@section('javascriptForm')
    <script src="{{ asset('app\lib\angular.min.js')}}"></script>
    <script src="{{ asset('app\app.js')}}"></script>
    <script src="{{ asset('app\controller\admin\productController.js')}}"></script>
    <script src="{{ asset('app\message.js')}}"></script>
    <script src="{{ asset('app\lib\tinymce.min.js')}}"></script>
    <script>
        var urlImage = '{{asset('')}}';
        var isFormValid = true;
        function validateInput(){
            isFormValid = true;
            document.querySelector('#messOption').innerText = '';
        };
        $(document).on('ready', function () {
            //Validate
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
            const submit = document.querySelector('.auth-form__submit');
            let input = document.querySelectorAll('.infoProduct');
            input.forEach((blurs,index) =>{
                blurs.oninput = function(){
                    if(index != 1 && index!= 2 && index!= 6){
                        remove_oninput(input[index].parentElement);
                        isFormValid = true;
                    }
                }
            })
            submit.onclick = function(){
                let inputProductOption = document.querySelectorAll('.infoProductOption');
                for(let i = 0; i < inputProductOption.length-8;i++){
                    function tests(){
                        return inputProductOption[i].value.trim().length >= 1 ? undefined :  `Hãy nhập trường này`;
                    }
                    if(tests() == null){
                    }
                    else{
                        document.querySelector('#messOption').innerText = 'Hãy hoàn thành các thông tin cần thiết';
                        isFormValid = false;
                        active__messageNotification("Hãy hoàn thành các thông tin cần thiết",false);
                        break;
                    }
                }
                for(var i = 0; i < input.length;i++){
                    if(i != 1 && i!= 2 && i!= 6){
                        function tests(){
                            if(i == 7){
                                return input[i].value != 0 ? undefined :  `Hãy chọn danh mục cha`;
                            }
                            else if (i == 8){
                                return input[i].value != 0 ? undefined :  `Hãy chọn thương hiệu`;
                            }
                            else {
                                return input[i].value.trim().length >= 1 ? undefined :  `Hãy nhập trường này`;
                            }
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
                let imageProductOption = document.querySelector('#imageProductOption');
                if(imageProductOption == null){
                    document.querySelector('#messOptionProductImage').innerText = 'Thêm ít nhất một hình ảnh';
                    isFormValid = false;
                }
                if(isFormValid == true){

                }
            }

            //EndValidate
            // // INITIALIZATION OF FORM SEARCH
            // // =======================================================
            // $('.js-form-search').each(function () {
            //     new HSFormSearch($(this)).init()
            // });
            // // INITIALIZATION OF ADD INPUT FILED
            // // =======================================================
            $('.js-add-field').each(function () {
                new HSAddField($(this), {
                    addedField: function() {
                        $('.js-add-field .js-select2-custom-dynamic').each(function () {
                            var select2dynamic = $.HSCore.components.HSSelect2.init($(this));
                        });
                    }
                }).init();
            });
        });
        Dropzone.options.dropzoneForm = {
            autoProcessQueue : true,
            acceptedFiles : ".png,.jpg,.gif,.bmp,.jpeg",
            url : '{{route('dropzone.upload')}}',
            init:function(){
                //var submitButton = document.querySelector("#submit-all");
                myDropzone = this;

                // submitButton.addEventListener('click', function(){
                //     myDropzone.processQueue();
                // });

                this.on("complete", function(){
                    if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
                    {
                        var _this = this;
                        _this.removeAllFiles();
                    }
                    load_images();
                });
            }
        };
        Dropzone.options.dropzoneForm2 = {
            autoProcessQueue : true,
            acceptedFiles : ".png,.jpg,.gif,.bmp,.jpeg",
            url : '{{route('dropzone.uploadEdit')}}',
            init:function(){
                myDropzone = this;
                this.on("complete", function(){
                    if(this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0)
                    {
                        var _this = this;
                        _this.removeAllFiles();
                    }
                    load_imagesEdit();
                });
            }
        };
        load_images();
        function load_images()
        {
            $.ajax({
                url:"{{ route('dropzone.fetch') }}",
                success:function(data)
                {
                    $('#uploaded_image').html(data);
                    document.querySelector('#messOptionProductImage').innerText = '';
                    isFormValid = true
                }
            })
        }
        function load_imagesEdit()
        {
            $.ajax({
                url:"{{ route('dropzone.fetchEdit') }}",
                success:function(data)
                {
                    $('#uploaded_image').html(data);
                }
            })
        }
        $(document).on('click', '.remove_image', function(){
            var name = $(this).attr('id');
            $.ajax({
                url:"{{ route('dropzone.delete') }}",
                data:{name : name},
                success:function(data){
                    load_images();
                }
            })
        });
        $(document).on('click', '.setImageMain', function(){
            var name = $(this).attr('id');
            $.ajax({
                url:"{{ route('dropzone.setImageMain') }}",
                data:{name : name},
                success:function(data){
                    load_images();
                }
            })
        });
        // Edit set image Main
        $(document).on('click', '.editRemove_image', function(){
            var name = $(this).attr('id');
            $.ajax({
                url:"{{ route('dropzone.deleteEdit') }}",
                data:{name : name},
                success:function(data){
                    load_imagesEdit();
                }
            })
        });
        $(document).on('click', '.editSetImageMain', function(){
            var name = $(this).attr('id');
            $.ajax({
                url:"{{ route('dropzone.setImageProductMain') }}",
                data:{name : name},
                success:function(data){
                    load_imagesEdit();
                }
            })
        });
        // End edit set image Main
        //Set color
        $(document).on('input', '.inputColor', function(){
            setColorFormat(this);
        });
        // End set color
        //Set color
        $(document).on('input', '.inputPrice', function(){
            setPriceFormat(this);
        });
        // End set color
        function setColorFormat(inputElement){
            let val = inputElement.value;
            let elm = inputElement.parentElement;
            let name =  elm.querySelector('.inputColorScreen');
            name.style.backgroundColor = val;
        }
        function setPriceFormat(inputElement){
            let val = inputElement.value;
            let elm = inputElement.parentElement;
            let name =  elm.querySelector('.inputPriceScreen');
            name.innerText = Number(val).toLocaleString("en") + ' VNĐ';
        }
        var editor_config = {
            path_absolute : "/",
            selector: 'textarea.my-editor',
            relative_urls: false,
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table directionality",
                "emoticons template paste textpattern"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            file_picker_callback : function(callback, value, meta) {
                var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

                var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url : cmsURL,
                    title : 'Filemanager',
                    width : x * 0.8,
                    height : y * 0.8,
                    resizable : "yes",
                    close_previous : "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        };
        tinymce.init(editor_config);
    </script>
@endsection

@section('content')
    <div ng-app="my-app">
        <!-- Content -->
        <div class="content container-fluid" ng-controller="productController">
            <!-- Page Header -->
            <div>
                <div class="row align-items-center mb-3">
                    <div class="col-sm mb-2 mb-sm-0">
                        <h1 class="page-header-title">Sản phẩm <span class="badge badge-soft-dark ml-2">@{{ amount }}</span></h1>
                    </div>

                    <div class="col-sm-auto">
                        <a class="btn btn-primary" ng-click="modal('add')"  data-toggle="modal" data-target="#exampleModal1">Thêm sản phẩm</a>
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
                        <th title="Click để sắp xếp" style="cursor: pointer" scope="col" ng-click="sort('name')">Sản phẩm
                            <span class="glyphicon sort-icon" ng-show="sortKey=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                        </th>
                        <th title="Click để sắp xếp" style="cursor: pointer" scope="col" ng-click="sort('categoryName')">Danh mục
                            <span class="glyphicon sort-icon" ng-show="sortKey=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
                        </th>
                        <th title="Click để sắp xếp" style="cursor: pointer" scope="col" ng-click="sort('trademarkName')">Thương hiệu
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
                            <div class="media align-items-center">
                                <img class="avatar avatar-lg mr-3" ng-src="{{asset('')}}@{{ val.image_path }}" alt="Image Description">
                                <div class="media-body">
                                    <h5 class="text-hover-primary mb-0">@{{val.name}}</h5>
                                </div>
                            </div>
                        </td>
                        <td style="vertical-align: middle;">
                            <h5 class="text-hover-primary mb-0">
                                @{{val.categoryName}}
                            </h5>
                        </td>
                        <td style="vertical-align: middle;">
                            <h5 class="text-hover-primary mb-0">
                                @{{val.trademarkName}}
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


            <!-- Modal -->
            <div class="modal fade bd-example-modal-xl" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title h4" id="myExtraLargeModalLabel">@{{frmTitle}}</h5>
                            <button type="button" class="btn btn-xs btn-icon btn-ghost-secondary" data-dismiss="modal" aria-label="Close">
                                <i class="tio-clear tio-lg"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <!-- Card -->
                                    <div class="card mb-3 mb-lg-5">
                                        <!-- Header -->
                                        <div class="card-header">
                                            <h4 class="card-header-title">Thông tin sản phẩm</h4>
                                        </div>
                                        <!-- End Header -->

                                        <!-- Body -->
                                        <div class="card-body">
                                            <!-- Form Group -->
                                            <div class="form-group">
                                                <label for="productNameLabel" class="input-label">Tên sản phẩm <i class="tio-help-outlined text-body ml-1" data-toggle="tooltip" data-placement="top" title="Tên sản phẩm"></i></label>

                                                <input ng-model="product.name" type="text" class="form-control infoProduct auth-form__input" name="productName" id="productNameLabel" placeholder="Nhập tên sản phẩm" aria-label="Nhập tên sản phẩm">
                                                <span class="form-message"></span>
                                            </div>
                                            <!-- End Form Group -->
                                        </div>
                                        <!-- Body -->
                                    </div>
                                    <!-- End Card -->

                                    <!-- Card -->
                                    <div class="card mb-3 mb-lg-5">
                                        <!-- Header -->
                                        <div class="card-header">
                                            <h4 class="card-header-title">Mô tả</h4>
                                        </div>
                                        <!-- End Header -->

                                        <!-- Body -->
                                        <div class="card-body">
                                            <textarea id="myTextarea" name="content" class="form-control my-editor infoProduct"></textarea>
                                        </div>
                                        <!-- Body -->
                                    </div>
                                    <!-- End Card -->

                                    <!-- Card -->
                                    <div class="card">
                                        <!-- Header -->
                                        <div class="card-header">
                                            <h4 class="card-header-title">Option <span id="messOption" class="form-message"></span></h4>
                                        </div>
                                        <!-- End Header -->

                                        <!-- Body -->
                                        <div class="card-body">

                                            <div class="js-add-field" data-hs-add-field-options='{
                                                      "template": "#addAnotherOptionFieldTemplate",
                                                      "container": "#addAnotherOptionFieldContainer",
                                                      "defaultCreated": 0
                                                    }'>
                                                <!-- Form Group -->
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="CPU" class="input-label">Vi xử lý (CPU)</label>

                                                                <input type="text" class="form-control infoProductOption auth-form__input" oninput="validateInput()" name="CPU" id="CPU" placeholder="Vi xử lý (CPU)" aria-label="Vi xử lý (CPU)">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="Ram" class="input-label">Ram (GB)</label>

                                                                <input type="number" class="form-control infoProductOption auth-form__input" oninput="validateInput()" name="Ram" id="Ram" placeholder="Ram" aria-label="Ram">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="display" class="input-label">Màn hình</label>

                                                                <input type="text" class="form-control infoProductOption auth-form__input" oninput="validateInput()" name="display" id="display" placeholder="Màn hình" aria-label="Màn hình">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="GPU" class="input-label">Card đồ họa (GPU)</label>

                                                                <input type="text" class="form-control infoProductOption auth-form__input" oninput="validateInput()" name="GPU" id="GPU" placeholder="Card đồ họa (GPU)" aria-label="Card đồ họa (GPU)">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="ROM" class="input-label">Lưu trữ (GB)</label>

                                                                <input type="number" class="form-control infoProductOption auth-form__input" oninput="validateInput()" name="ROM" id="ROM" placeholder="Lưu trữ" aria-label="Lưu trữ">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="color" class="input-label">Màu <span style="margin-left: 6px;" class="inputColorScreen"></span></label>

                                                                <input type="text" class="form-control inputColor infoProductOption auth-form__input" oninput="validateInput()" name="color" id="color" placeholder="Nhập mã màu" aria-label="Màu">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="price" class="input-label">Giá <span style="margin-left: 6px;" class="inputPriceScreen"></span></label>

                                                                <input type="number" class="form-control inputPrice infoProductOption auth-form__input" oninput="validateInput()" name="price" id="price" placeholder="Giá mặc định" aria-label="Giá mặc định">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="priceSale" class="input-label">Giá khuyến mại <span style="margin-left: 6px;" class="inputPriceScreen"></span></label>

                                                                <input type="number" class="form-control inputPrice infoProductOption auth-form__input" oninput="validateInput()" name="priceSale" id="priceSale" placeholder="Giá khuyến mại" aria-label="Giá khuyến mại">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Form Group -->

                                                <!-- Container For Input Field -->
                                                <div id="addAnotherOptionFieldContainer"></div>

                                                <a id="AddField" href="javascript:;" class="js-create-field btn btn-sm btn-no-focus btn-ghost-primary">
                                                    <i class="tio-add"></i> Thêm option
                                                </a>
                                            </div>

                                            <!-- Add Another Option Input Field -->
                                            <div id="addAnotherOptionFieldTemplate" style="display: none;">
                                                <!-- Form Group -->
                                                <div class="form-group input-group-add-field">
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="CPU" class="input-label">Vi xử lý (CPU)</label>

                                                                <input type="text" class="form-control infoProductOption auth-form__input" oninput="validateInput()" name="CPU" id="CPU" placeholder="Vi xử lý (CPU)" aria-label="Vi xử lý (CPU)">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="Ram" class="input-label">Ram (GB)</label>

                                                                <input type="number" class="form-control infoProductOption auth-form__input" oninput="validateInput()" name="Ram" id="Ram" placeholder="Ram" aria-label="Ram">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="display" class="input-label">Màn hình</label>

                                                                <input type="text" class="form-control infoProductOption auth-form__input" oninput="validateInput()" name="display" id="display" placeholder="Màn hình" aria-label="Màn hình">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="GPU" class="input-label">Card đồ họa (GPU)</label>

                                                                <input type="text" class="form-control infoProductOption auth-form__input" oninput="validateInput()" name="GPU" id="GPU" placeholder="Card đồ họa (GPU)" aria-label="Card đồ họa (GPU)">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="ROM" class="input-label">Lưu trữ (GB)</label>

                                                                <input type="number" class="form-control infoProductOption auth-form__input" oninput="validateInput()" name="ROM" id="ROM" placeholder="Lưu trữ" aria-label="Lưu trữ">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="color" class="input-label">Màu <span style="margin-left: 6px;" class="inputColorScreen"></span></label>

                                                                <input type="text" class="form-control inputColor infoProductOption auth-form__input" oninput="validateInput()" name="color" id="color" placeholder="Nhập mã màu" aria-label="Màu">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="price" class="input-label">Giá <span style="margin-left: 6px;" class="inputPriceScreen"></span></label>

                                                                <input type="number" class="form-control inputPrice infoProductOption auth-form__input" oninput="validateInput()" name="price" id="price" placeholder="Giá mặc định" aria-label="Giá mặc định">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- Form Group -->
                                                            <div class="form-group">
                                                                <label for="priceSale" class="input-label">Giá khuyến mại <span style="margin-left: 6px;" class="inputPriceScreen"></span></label>

                                                                <input type="number" class="form-control inputPrice infoProductOption auth-form__input" oninput="validateInput()" name="priceSale" id="priceSale" placeholder="Giá khuyến mại" aria-label="Giá khuyến mại">
                                                                <span class="form-message"></span>
                                                            </div>
                                                            <!-- End Form Group -->
                                                        </div>
                                                    </div>
                                                    <a class="js-delete-field input-group-add-field-delete closeProductOption" href="javascript:;">
                                                        <i class="tio-clear"></i>
                                                    </a>
                                                </div>
                                                <!-- End Form Group -->
                                            </div>
                                            <!-- End Add Another Option Input Field -->
                                        </div>
                                        <!-- Body -->
                                    </div>
                                    <!-- End Card -->
                                </div>

                                <div class="col-lg-4">
                                    <!-- Card -->
                                    <div class="card mb-3 mb-lg-5">
                                        <!-- Header -->
                                        <div class="card-header">
                                            <h4 class="card-header-title">Hoạt động</h4>
                                        </div>
                                        <!-- End Header -->

                                        <!-- Body -->
                                        <div class="card-body">
                                            <!-- Toggle Switch -->
                                            <label class="row toggle-switch" for="availabilitySwitch1">
                                                <span class="col-8 col-sm-9 toggle-switch-content">
                                                    <span class="text-dark">Kích hoạt</span>
                                                </span>
                                                <span class="col-4 col-sm-3">
                                                    <input type="checkbox" checked class="toggle-switch-input infoProduct" id="availabilitySwitch1">
                                                    <span class="toggle-switch-label ml-auto">
                                                        <span class="toggle-switch-indicator"></span>
                                                    </span>
                                                </span>
                                            </label>
                                            <!-- End Toggle Switch -->
                                        </div>
                                        <!-- Body -->
                                    </div>
                                    <!-- End Card -->

                                    <!-- Card -->
                                    <div class="card mb-3 mb-lg-5">
                                        <!-- Header -->
                                        <div class="card-header">
                                            <h4 class="card-header-title">Thông tin khác</h4>
                                        </div>
                                        <!-- End Header -->

                                        <!-- Body -->
                                        <div class="card-body">
                                            <!-- Form Group -->
                                            <div class="form-group">
                                                <label for="connect" class="input-label">Kết nối chính</label>

                                                <input type="text" ng-model="product.connect"  class="form-control infoProduct auth-form__input" name="connect" id="connect" placeholder="Kết nối chính" aria-label="Kết nối chính">
                                                <span class="form-message"></span>
                                            </div>
                                            <!-- End Form Group -->
                                            <!-- Form Group -->
                                            <div class="form-group">
                                                <label for="weight" class="input-label">Trọng lượng Kg</label>

                                                <input type="number" class="form-control infoProduct auth-form__input" name="weight" id="weight" placeholder="Trọng lượng" aria-label="Trọng lượng">
                                                <span class="form-message"></span>
                                            </div>
                                            <!-- End Form Group -->
                                            <!-- Form Group -->
                                            <div class="form-group">
                                                <label for="Pin" class="input-label">Pin</label>

                                                <input type="text" ng-model="product.battery"  class="form-control infoProduct auth-form__input" name="Pin" id="Pin" placeholder="Pin" aria-label="Pin">
                                                <span class="form-message"></span>
                                            </div>
                                            <!-- End Form Group -->

                                            <!-- Form Group -->
                                            <div class="form-group">
                                                <label for="Pin" class="input-label">Khuyến mại</label>

                                                <input type="text" ng-model="product.promotion"  class="form-control infoProduct auth-form__input" name="promotion" id="promotion" placeholder="Khuyến mại" aria-label="promotion">
                                                <span class="form-message"></span>
                                            </div>
                                            <!-- End Form Group -->

                                            <!-- Form Group -->
                                            <div class="form-group">
                                                <label for="categoryLabel" class="input-label">Danh mục</label>

                                                <!-- Select -->
                                                <select class="custom-select infoProduct auth-form__input" id="categoryLabel">
                                                </select>
                                                <span class="form-message"></span>
                                                <!-- End Select -->
                                            </div>
                                            <div class="form-group">
                                                <label for="categoryLabel" class="input-label">Thương hiệu</label>

                                                <!-- Select -->
                                                <select class="custom-select infoProduct auth-form__input" id="trademarkLabel">
                                                </select>
                                                <span class="form-message"></span>
                                                <!-- End Select -->
                                            </div>
                                            <!-- End Form Group -->

                                            <!-- Form Group -->
{{--                                            <div class="form-group">--}}
{{--                                                <label for="code" class="input-label">Mã giảm giá</label>--}}

{{--                                                <input type="text" class="form-control" name="code" id="code" placeholder="Mã giảm giá" aria-label="Mã giảm giá">--}}
{{--                                                <span class="form-message"></span>--}}
{{--                                            </div>--}}
                                            <!-- End Form Group -->
                                        </div>
                                        <!-- End Body -->
                                    </div>
                                    <!-- End Card -->

                                    <!-- Card -->
                                    <div class="card">
                                        <!-- Header -->
                                        <div class="card-header">
                                            <h4 class="card-header-title">Hình ảnh <span id="messOptionProductImage" class="form-message"></span></h4>
                                        </div>
                                        <!-- End Header -->
{{--                                        action="{{route('dropzone.upload')}}--}}
                                        <!-- Body -->
                                        <div class="card-body">
                                            <form id="dropzoneForm" class="dropzone">
                                                @csrf
                                            </form>
                                            <form id="dropzoneForm2" class="dropzone">
                                                @csrf
                                            </form>
                                            <div class="panel panel-default">
                                                <div class="panel-body" id="uploaded_image">

                                                </div>
                                            </div>
                                        </div>
                                        <!-- Body -->
                                    </div>
                                    <!-- End Card -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="closeForm1" class="btn btn-white" data-dismiss="modal">đóng</button>
                            <button id="submit-all" ng-click = "save(state,id)" type="button" class="btn btn-primary auth-form__submit">
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
                            Bạn có chắc chắn muốn xoá sản phẩm "@{{name}}"
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
