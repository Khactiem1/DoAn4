app.controller('categoryController' ,function ($scope,$http,API) {
    function LoadData(){
        $http.get(API + 'discount/list').then(function (response) {
            $scope.data = response.data;
            $scope.amount = response.data.length;
        });
    }
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
    $scope.stateApply = function (value){
        stateApply = value;
    }
    $scope.modal = function (state,id,name){
        $scope.state = state;
        switch (state){
            case 'add':
                if ($scope.discount) {
                    delete $scope.discount;
                }
                $scope.frmTitle = "Thêm mã giảm giá";
                break;
            case 'delete':
                $scope.frmTitle = "Xoá mã giảm giá";
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
                if($scope.discount.price <= 0){
                    active__messageNotification("Không thể khuyến mại giá trị âm hoặc 0",false);
                    return;
                }
                if(document.getElementById('option-price').value == 0){
                    if($scope.discount.price > 100){
                        active__messageNotification("Không thể khuyến mại quá 100%",false);
                        return;
                    }
                }
                if(document.getElementById('option-quantity').value == 0){
                    if($scope.discount.quantity <= 0){
                        active__messageNotification("Không thể khuyến mại số lượng sản phẩm âm hoặc bằng 0",false);
                        return;
                    }
                }
                btnSubmit[0].classList.add('submit-loadding');
                var url = API + 'discount/add';
                var data = {
                    discount : $scope.discount,
                    stateApply: stateApply,
                    optionPrice : document.getElementById('option-price').value,
                    optionQuantity : document.getElementById('option-quantity').value,
                    optionDate : document.getElementById('option-date').value
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
                        active__messageNotification("Mã giảm giá này đã tồn tại",false);
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
            $http.get(API + 'discount/delete/' + id).then(function (res) {
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
