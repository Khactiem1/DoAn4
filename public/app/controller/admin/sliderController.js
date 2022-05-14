app.directive("fileread", [function () {
    return {
        scope: {
            fileread: "="
        },
        link: function (scope, element, attributes) {
            element.bind("change", function (changeEvent) {
                var reader = new FileReader();
                reader.onload = function (loadEvent) {
                    scope.$apply(function () {
                        scope.fileread = loadEvent.target.result;
                    });
                }
                reader.readAsDataURL(changeEvent.target.files[0]);
            });
        }
    }
}]);
app.controller('sliderController' ,function ($scope,$http,API) {
    function LoadData(){
        $http.get(API + 'slider/list').then(function (response) {
            $scope.data = response.data;
            $scope.amount = response.data.length;
        });
    }

    document.getElementById("fileAttachmentBtn").onchange = function (ev) {
        var reader = new FileReader();
        const files = ev.target.files;
        reader.onload = function (e) {
            // get loaded data and render thumbnail.
            document.getElementById("trademark-image").src = e.target.result;
        };
        // read the image file as a data URL.
        reader.readAsDataURL(this.files[0]);
    };


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
    LoadData();
    $scope.sort = function(keyname){
        $scope.sortKey = keyname;   //set the sortKey to the param passed
        $scope.reverse = !$scope.reverse; //if true make it false and vice versa
    }
    $scope.modal = function (state,id,name){
        $scope.state = state;
        switch (state){
            case 'add':
                if(document.getElementById('name').value != ''){
                    document.getElementById('customFileExample5').innerText = 'Hình ảnh';
                    document.getElementById('name').value = '';
                    document.getElementById("trademark-image").removeAttribute("src");
                    document.getElementById('fileAttachmentBtn').value = '';
                }
                $scope.frmTitle = "Thêm slider";
                break;
            case 'edit':
                document.getElementById('customFileExample5').innerText = 'Hình ảnh';
                $scope.frmTitle = "Sửa slider";
                $scope.id = id;
                $http.get(API + 'slider/edit/' + id).then(function (res){
                    $scope.trademark = res.data;
                    document.getElementById("trademark-image").src = urlImage + res.data.image_path;
                });
                break;
            case 'delete':
                $scope.frmTitle = "Xoá slider";
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
                if(document.getElementById('trademark-image').getAttribute("src") == null){
                    active__messageNotification("Hãy chọn hình ảnh cho slider",false);
                }
                else {
                    btnSubmit[0].classList.add('submit-loadding');
                    var url = API + 'slider/add';
                    var data =$scope.trademark;
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
                            active__messageNotification("Tên slider đã tồn tại",false);
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
        }
        else if (state == 'edit'){
            if(isFormValid == true){
                btnSubmit[0].classList.add('submit-loadding');
                var url = API + 'slider/edit/' + id;
                var input = document.querySelectorAll('.auth-form__input');
                var data =$scope.trademark;
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
                        active__messageNotification("Tên slider này đã tồn tại",false);
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
            $http.get(API + 'slider/delete/' + id).then(function (res) {
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
