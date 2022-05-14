app.controller('myController' ,function ($scope,$http,API) {
    function LoadData(){
        $http.get(API + 'data/list').then(function (response) {
            $scope.data = response.data.products;
        });
    }
    function LoadCart(){
        $http.get(API + 'data/getCart').then(function (response) {
            $scope.cart = response.data;
            $scope.lengthCart = response.data.length;
        });
    }
    LoadCart();
    LoadData();
    $scope.searchTrademark = function (id){
        $scope.data = [];
        document.getElementById('loadSearch').classList.remove('none');
        $http.get(API + 'data/listProductTrademark/'+id).then(function (response) {
            document.getElementById('loadSearch').classList.add('none');
            if(response.data.products.length == 0){
                active__messageNotification("Thương hiệu này tạm thời hết hàng",false);
            }
            $scope.data = response.data.products;
        });
    }
    $scope.searchCategory = function (id){
        $scope.data = [];
        document.getElementById('loadSearch').classList.remove('none');
        $http.get(API + 'data/listProductCategory/'+id).then(function (response) {
            document.getElementById('loadSearch').classList.add('none');
            if(response.data.products.length == 0){
                active__messageNotification("Danh mục này tạm thời hết hàng",false);
            }
            $scope.data = response.data.products;
        });
    }
    $scope.searchPrice = function (){
        $scope.data = [];
        document.getElementById('loadSearch').classList.remove('none');
        $http.get(API + 'data/listProductPrice/'+startPrice*1000000+'/'+endPrice*1000000).then(function (response) {
            document.getElementById('loadSearch').classList.add('none');
            if(response.data.products.length == 0){
                active__messageNotification("Không tìm thấy sản phẩm trong khoảng giá này",false);
            }
            $scope.data = response.data.products;
        });
    }
    $scope.addCard = function (id,option){
        $http.get(API + 'data/addCardDetail/'+id+'/'+option).then(function (response) {
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
});
let startPrice = 10;
let endPrice = 100;
function searchPrice(value){
    let arrayString = value.split(",");
    startPrice = arrayString[0];
    endPrice = arrayString[1];
}
