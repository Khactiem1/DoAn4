app.controller('myController' ,function ($scope,$http,API) {
    $scope.searchTrademark = function (id){
        window.location.href = 'http://localhost:8000/';
    }
    function LoadCart(){
        $http.get(API + 'data/getCart').then(function (response) {
            $scope.cart = response.data;
            $scope.lengthCart = response.data.length;
        });
    }
    LoadCart();
    $scope.priceSale = op1;
    $scope.price = op2;
    $scope.option = op;
    $scope.changeOption = function (id){
        document.querySelector('.option.active').classList.remove('active');
        document.querySelector('.option'+id).classList.add('active')
        $http.get(API + 'data/optionProduct/'+id).then(function (response) {
            $scope.priceSale = response.data.price_sale;
            $scope.price = response.data.price;
            $scope.option = id;
        });
    }
    $scope.addCard = function (id){
        $http.get(API + 'data/addCardDetail/'+id+'/'+$scope.option).then(function (response) {
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
