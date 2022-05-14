app.controller('productController' ,function ($scope,$http,API) {
    let categories = []
    $http.get(API + 'categories/list').then(function (response) {
        categories = response.data;
        let select = categorySelect(response.data);
        document.querySelector('#categoryLabel').innerHTML = select;
    });
    let trademark = []
    $http.get(API + 'trademark/list').then(function (response) {
        trademark = response.data;
        let select = trademarkSelect(response.data);
        document.querySelector('#trademarkLabel').innerHTML = select;
    });
    function LoadData(){
        $http.get(API + 'product/list').then(function (response) {
            $scope.data = response.data.products;
            $scope.amount = response.data.products.length;
        });
    }
    LoadData();
    function loadCategories(arr,recordEdit){
        let select = categorySelect(arr,recordEdit);
        document.querySelector('#categoryLabel').innerHTML = select;
    }
    function loadFormModal(inputProduct,inputProductOption){
        let btnCloseProductOption = document.querySelectorAll('.closeProductOption');
        let ColorFormat = document.querySelectorAll('.inputColorScreen');
        ColorFormat.forEach((elm,index) =>{
            elm.style.backgroundColor = '';
        })
        let PriceFormat = document.querySelectorAll('.inputPriceScreen');
        PriceFormat.forEach((elm,index) =>{
            elm.innerText = '';
        })
        for (let i =0; i<inputProductOption.length-8;i++){
            inputProductOption[i].value = '';
        }
        for (let i =0; i<inputProduct.length;i++){
            if(i != 1 && i != 2 && i != 6){
                inputProduct[i].value = '';
            }
        }
        for (let i =0; i<btnCloseProductOption.length;i++){
            btnCloseProductOption[i].click();
        }
        loadCategories(categories);
        let select2 = trademarkSelect(trademark);
        document.querySelector('#trademarkLabel').innerHTML = select2;
        tinymce.get("myTextarea").setContent("");
    }
    ///Page
    var page = 16;
    if(localStorage.getItem('page')){
        page = Number(localStorage.getItem('page'));
    }
    $scope.changePage = function (){
        var val = document.getElementById('pageInit').value.replace(/number:/g, '');
        localStorage.setItem('page', val);
    }
    $scope.pages = [
        {'id': 8, 'label': 'Hiển thị 8'},
        {'id': 16, 'label': 'Hiển thị 16'},
        {'id': 24, 'label': 'Hiển thị 24'},
        {'id': 32, 'label': 'Hiển thị 32'},
    ]
    $scope.page = {
        'unit': page
    }
    $scope.sort = function(keyname){
        $scope.sortKey = keyname;   //set the sortKey to the param passed
        $scope.reverse = !$scope.reverse; //if true make it false and vice versa
    }
    ///End page
    $scope.modal = function (state,id,name){
        $scope.state = state;
        let inputProductOption = document.querySelectorAll('.infoProductOption');
        let inputProduct = document.querySelectorAll('.infoProduct');
        switch (state){
            case 'add':
                document.getElementById('dropzoneForm').classList.remove('none');
                document.getElementById('dropzoneForm2').classList.add('none');
                document.getElementById('availabilitySwitch1').checked = true;
                if ($scope.product) {
                    delete $scope.product;
                    loadFormModal(inputProduct,inputProductOption);
                }
                $scope.frmTitle = "Thêm sản phẩm";
                load_images();
                break;
            case 'edit':
                document.getElementById('dropzoneForm').classList.add('none');
                document.getElementById('dropzoneForm2').classList.remove('none');
                $scope.frmTitle = "Sửa sản phẩm";
                $scope.id = id;
                if ($scope.product) {
                    delete $scope.product;
                }
                $http.get(API + 'product/edit/' + id).then(function (res){
                    loadFormModal(inputProduct,inputProductOption);
                    $scope.product = res.data.product;
                    if(res.data.product.description == null){
                        tinymce.get("myTextarea").setContent('');
                    }
                    else {
                        tinymce.get("myTextarea").setContent(res.data.product.description);
                    }
                    document.getElementById('weight').value = res.data.product.weight;
                    let select = categorySelect(categories,res.data.category);
                    document.querySelector('#categoryLabel').innerHTML = select;
                    let select2 = trademarkSelect(trademark,res.data.product);
                    document.querySelector('#trademarkLabel').innerHTML = select2;
                    for (let i = 0; i < res.data.option.length - 1; i ++){
                        document.getElementById('AddField').click();
                    }
                    let inputProductOptionEdit = document.querySelectorAll('.infoProductOption');
                    let count = -8;
                    for (let i = 0; i < res.data.option.length; i++){
                        count +=8;
                        inputProductOptionEdit[count].value =  res.data.option[i].CPU;
                        inputProductOptionEdit[count+1].value =  res.data.option[i].RAM;
                        inputProductOptionEdit[count+2].value =  res.data.option[i].display;
                        inputProductOptionEdit[count+3].value =  res.data.option[i].VGA;
                        inputProductOptionEdit[count+4].value =  res.data.option[i].ROM;
                        inputProductOptionEdit[count+5].value =  res.data.option[i].color;
                        setColorFormat(inputProductOptionEdit[count+5]);
                        inputProductOptionEdit[count+6].value =  res.data.option[i].price;
                        setPriceFormat(inputProductOptionEdit[count+6]);
                        inputProductOptionEdit[count+7].value =  res.data.option[i].price_sale;
                        setPriceFormat(inputProductOptionEdit[count+7]);
                    }
                    if(res.data.product.status == false || res.data.product.status == 'false' || res.data.product.status == 'False'){
                        document.getElementById('availabilitySwitch1').checked = false;
                    }
                    else {
                        document.getElementById('availabilitySwitch1').checked = true;
                    }
                    $('#uploaded_image').html(res.data.image);
                });
                break;
            case 'delete':
                $scope.frmTitle = "Xoá sản phẩm";
                $scope.id = id;
                $scope.name = name;
                break;
            default:
                $scope.frmTitle = 'Chưa xác định form';
                break;
        }
    }
    var btnSubmit = document.querySelectorAll('.auth-form__submit');
    $scope.save = function (state,id){
        if(state == 'add'){
            if(isFormValid == true){
                let inputProductOption = document.querySelectorAll('.infoProductOption');
                let option = [];
                for (let i =0; i<inputProductOption.length-8;i+=8){
                    let op = {
                        CPU : inputProductOption[i].value.trim(),
                        RAM : inputProductOption[i+1].value.trim(),
                        display : inputProductOption[i+2].value.trim(),
                        VGA : inputProductOption[i+3].value.trim(),
                        ROM : inputProductOption[i+4].value.trim(),
                        color : inputProductOption[i+5].value.trim(),
                        price : inputProductOption[i+6].value.trim(),
                        price_sale : inputProductOption[i+7].value.trim(),
                    };
                    option.push(op);
                }
                btnSubmit[0].classList.add('submit-loadding');
                let url = API + 'product/add';
                let inputProduct = document.querySelectorAll('.infoProduct');
                let myContent = tinymce.get("myTextarea").getContent();
                let data = {
                    name : inputProduct[0].value.trim(),
                    description : myContent,
                    status : inputProduct[2].checked + '',
                    connect : inputProduct[3].value.trim(),
                    weight : inputProduct[4].value.trim(),
                    battery : inputProduct[5].value.trim(),
                    promotion : inputProduct[6].value.trim(),
                    category_id : inputProduct[7].value,
                    trademark_id : inputProduct[8].value,
                    productOption : option,
                };
                $http({
                    method: 'POST',
                    url: url,
                    data: data
                }).then(function (res){
                    btnSubmit[0].classList.remove('submit-loadding');
                    if(res.data.status == 'T'){
                        LoadData();
                        loadFormModal(inputProduct,inputProductOption);
                        load_images();
                        active__messageNotification("Thêm thành công",true);
                        document.getElementById('closeForm1').click();
                    }
                    else if (res.data.status == 'F'){
                        active__messageNotification("Tên sản phẩm đã tồn tại",false);
                    }
                    else {
                        active__messageNotification("Có lỗi xảy ra hãy thử lại sau",false);
                    }
                }).catch(function (res){
                    btnSubmit[0].classList.remove('submit-loadding');
                    active__messageNotification("Có lỗi xảy ra hãy thử lại sau",false);
                });
            }
        }
        else if (state == 'edit'){
            if(isFormValid == true){
                let inputProductOption = document.querySelectorAll('.infoProductOption');
                let option = [];
                for (let i =0; i<inputProductOption.length-8;i+=8){
                    let op = {
                        CPU : inputProductOption[i].value.trim(),
                        RAM : inputProductOption[i+1].value.trim(),
                        display : inputProductOption[i+2].value.trim(),
                        VGA : inputProductOption[i+3].value.trim(),
                        ROM : inputProductOption[i+4].value.trim(),
                        color : inputProductOption[i+5].value.trim(),
                        price : inputProductOption[i+6].value.trim(),
                        price_sale : inputProductOption[i+7].value.trim(),
                    };
                    option.push(op);
                }
                btnSubmit[0].classList.add('submit-loadding');
                let url = API + 'product/edit/' + id;
                let inputProduct = document.querySelectorAll('.infoProduct');
                let myContent = tinymce.get("myTextarea").getContent();
                let data = {
                    name : inputProduct[0].value.trim(),
                    description : myContent,
                    status : inputProduct[2].checked + '',
                    connect : inputProduct[3].value.trim(),
                    weight : inputProduct[4].value.trim(),
                    battery : inputProduct[5].value.trim(),
                    promotion : inputProduct[6].value.trim(),
                    category_id : inputProduct[7].value,
                    trademark_id : inputProduct[8].value,
                    productOption : option,
                };
                $http({
                    method: 'POST',
                    url: url,
                    data: data
                }).then(function (res){
                    btnSubmit[0].classList.remove('submit-loadding');
                    if(res.data.status == 'T'){
                        LoadData();
                        loadFormModal(inputProduct,inputProductOption);
                        load_images();
                        active__messageNotification("Sửa thành công",true);
                        document.getElementById('closeForm1').click();
                    }
                    else if(res.data.status == 'F'){
                        active__messageNotification("Tên sản phẩm đã tồn tại",false);
                    }
                    else {
                        active__messageNotification("Có lỗi xảy ra hãy thử lại sau",false);
                    }
                }).catch(function (res){
                    btnSubmit[0].classList.remove('submit-loadding');
                    active__messageNotification("Có lỗi xảy ra hãy thử lại sau",false);
                });
            }
        }
        else if (state == 'delete'){
            btnSubmit[1].classList.add('submit-loadding');
            $http.get(API + 'product/delete/' + id).then(function (res) {
                btnSubmit[1].classList.remove('submit-loadding');
                if(res.data.status == 'T'){
                    LoadData();
                    active__messageNotification("Xoá thành công",true);
                    document.getElementById('closeForm2').click();
                }
                else {
                    active__messageNotification("Có lỗi xảy ra hãy thử lại sau",false);
                }
            }).catch(function (res){
                btnSubmit[1].classList.remove('submit-loadding');
                active__messageNotification("Có lỗi xảy ra hãy thử lại sau",false);
            });
        }
    }
});
function categorySelect(array,recordEdit){
    let htmlSelect = '<option value="0">Chọn danh mục</option>';
    function categoryRecusive(id,text = ''){
        for (let i = array.length - 1; i >= 0; i--){
            if(array[i].parent_id == id){
                if(recordEdit){
                    if(recordEdit.id == array[i].id){
                        htmlSelect += '<option selected value="' + array[i].id + '">' + text + array[i].name +'</option>';
                    }
                    else {
                        htmlSelect += '<option value="' + array[i].id + '">' + text + array[i].name +'</option>';
                    }
                }
                else {
                    htmlSelect += '<option value="' + array[i].id + '">' + text + array[i].name +'</option>';
                }
                categoryRecusive(array[i].id,text + '-');
            }
        }
        return htmlSelect;
    }
    categoryRecusive(0);
    return htmlSelect;
}
function trademarkSelect(array,recordEdit){
    let htmlSelect = '<option value="0">Chọn thương hiệu</option>';
    for (let i = array.length - 1; i >= 0; i--){
        if(recordEdit){
            if(recordEdit.trademark_id == array[i].id){
                htmlSelect += '<option selected value="' + array[i].id + '">' + array[i].name +'</option>';
            }
            else {
                htmlSelect += '<option value="' + array[i].id + '">' + array[i].name +'</option>';
            }
        }
        else {
            htmlSelect += '<option value="' + array[i].id + '">' + array[i].name +'</option>';
        }
    }
    return htmlSelect;
}
