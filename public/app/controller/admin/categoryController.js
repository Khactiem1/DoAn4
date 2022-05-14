app.controller('categoryController' ,function ($scope,$http,API) {
    function LoadData(){
        $http.get(API + 'categories/list').then(function (response) {
            $scope.data = response.data;
            $scope.amount = response.data.length;
            let select = categorySelect(response.data);
            document.querySelector('#parent_idSelect').innerHTML = select;
        });
    }
    var page = 16;
    if(localStorage.getItem('page')){
        page = Number(localStorage.getItem('page'));
    }
    function categorySelect(array,recordEdit){


        let htmlSelect = '<option value="0">Danh mục cha</option>';
        function categoryRecusive(id,text = ''){
            for (let i = array.length - 1; i >= 0; i--){
                if(array[i].parent_id == id){
                    if(recordEdit){
                        if(recordEdit.id != array[i].id){
                            if(recordEdit.parent_id == array[i].id){
                                htmlSelect += '<option selected value="' + array[i].id + '">' + text + array[i].name +'</option>';
                            }
                            else {
                                htmlSelect += '<option value="' + array[i].id + '">' + text + array[i].name +'</option>';
                            }
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
    LoadData();
    $scope.sort = function(keyname){
        $scope.sortKey = keyname;   //set the sortKey to the param passed
        $scope.reverse = !$scope.reverse; //if true make it false and vice versa
    }
    $scope.modal = function (state,id,name){
        $scope.state = state;
        switch (state){
            case 'add':
                if ($scope.categories) {
                    delete $scope.categories;
                    let select = categorySelect($scope.data);
                    document.querySelector('#parent_idSelect').innerHTML = select;
                }
                $scope.frmTitle = "Thêm danh mục";
                break;
            case 'edit':
                $scope.frmTitle = "Sửa danh mục";
                $scope.id = id;
                $http.get(API + 'categories/edit/' + id).then(function (res){
                    $scope.categories = res.data;
                    let select = categorySelect($scope.data,res.data);
                    document.querySelector('#parent_idSelect').innerHTML = select;
                });
                break;
            case 'delete':
                $scope.frmTitle = "Xoá danh mục";
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
                btnSubmit[0].classList.add('submit-loadding');
                var url = API + 'categories/add';
                var input = document.querySelectorAll('.auth-form__input');
                var data = {
                    name : input[0].value.trim(),
                    parent_id : input[1].value
                };
                $http({
                    method: 'POST',
                    url: url,
                    data: data
                }).then(function (res){
                    btnSubmit[0].classList.remove('submit-loadding');
                    if(res.data.status == 'T'){
                        LoadData();
                        active__messageNotification("Thêm thành công",true);
                        document.getElementById('closeForm1').click();
                    }
                    else if (res.data.status == 'F'){
                        active__messageNotification("Tên danh mục đã tồn tại",false);
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
                btnSubmit[0].classList.add('submit-loadding');
                var url = API + 'categories/edit/' + id;
                var input = document.querySelectorAll('.auth-form__input');
                var data = {
                    name : input[0].value.trim(),
                    parent_id : input[1].value
                };
                $http({
                    method: 'POST',
                    url: url,
                    data: data
                }).then(function (res){
                    btnSubmit[0].classList.remove('submit-loadding');
                    if(res.data.status == 'T'){
                        LoadData();
                        active__messageNotification("Sửa thành công",true);
                        document.getElementById('closeForm1').click();
                    }
                    else if(res.data.status == 'F'){
                        active__messageNotification("Tên danh mục này đã tồn tại",false);
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
            $http.get(API + 'categories/delete/' + id).then(function (res) {
                btnSubmit[1].classList.remove('submit-loadding');
                if(res.data.status == 'T'){
                    LoadData();
                    active__messageNotification("Xoá thành công",true);
                    document.getElementById('closeForm2').click();
                }
                else if (res.data.status == 'parent'){
                    active__messageNotification("Danh mục này là cha danh mục khác, chỉ có xoá được danh mục không có con",false);
                }
                else if (res.data.status == 'F'){
                    active__messageNotification("Đang có sản phẩm thuộc danh mục này, không thể xoá",false);
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
