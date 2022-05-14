app.controller('myController' ,function ($scope,$http,API) {
    $scope.searchTrademark = function (id){
        window.location.href = 'http://localhost:8000/';
    }
    function LoadCart(){
        $http.get(API + 'data/getCart').then(function (response) {
            $scope.total = 0;
            response.data.forEach((item,index)=>{
                $scope.total += item.option.price_sale * item.quality;
            })
            $scope.cart = response.data;
            $scope.lengthCart = response.data.length;
        });
        $http.get(API + 'data/getCode').then(function (response) {
            $scope.codes = response.data.discount;
            $scope.sale = response.data.priceSale;
        });
    }
    $scope.deleteCode = function (id){
        $http.get(API + 'data/deleteCode/'+id).then(function (response) {
            LoadCart();
        });
    }
    LoadCart();
    $scope.addCard = function (id,option){
        $http.get(API + 'data/addCardDetail/'+id+'/'+ option).then(function (response) {
            LoadCart();
            if(response.data == 'T'){
                active__messageNotification("Đã thêm sản phẩm vào giỏ",true);
            }
            else if(response.data == '++'){
                active__messageNotification("Đã tăng số lượng sản phẩm trong giỏ",true);
            }
        });
    }
    $scope.deleteCart = function (id,option){
        $http.get(API + 'data/deleteCardDetail/'+id+'/'+option).then(function (response) {
            LoadCart();
            if(response.data == 'T'){
                active__messageNotification("Đã xoá sản phẩm khỏi giỏ",true);
            }
        });
    }
    $scope.cartUp = function (id,option){
        $http.get(API + 'data/addCardDetail/'+id+'/'+option).then(function (response) {
            LoadCart();
        });
    }
    $scope.cartDown = function (id,option){
        $http.get(API + 'data/downCardDetail/'+id+'/'+option).then(function (response) {
            if(response.data == 'T'){
                active__messageNotification("Đã xoá sản phẩm khỏi giỏ",true);
            }
            LoadCart();
        });
    }
    $scope.applyCode = function (){
        $http.get(API + 'data/getSaleCode/'+$scope.searchCode).then(function (response) {
            if(response.data == 'F'){
                active__messageNotification("Khuyến mại không tồn tại",false);
            }
            else if(response.data == 'C'){
                active__messageNotification("Bạn đã áp dụng mã này",false);
            }
            else if(response.data == 'H'){
                active__messageNotification("Mã hết hạn sử dụng",false);
            }
            else if(response.data == '0'){
                active__messageNotification("Mã đã sử dụng hết",false);
            }
            else {
                $scope.searchCode = '';
                LoadCart();
            }
        });
    }
});
