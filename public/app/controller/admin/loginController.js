app.controller('loginController' ,function ($scope,$http,API) {
    $scope.messLogin = '';
    var btnSubmit = document.querySelectorAll('.auth-form__submit');
    $scope.login = function (){
        if(isFormValid == true){
            btnSubmit[0].classList.add('submit-loadding');
            var url = API + 'login';
            var input = document.querySelectorAll('.auth-form__input');
            var data = {
                name : input[0].value.trim(),
                password : input[1].value,
                remember : input[2].checked + ''
            };
            $http({
                method: 'POST',
                url: url,
                data: data
            }).then(function (res){
                btnSubmit[0].classList.remove('submit-loadding');
                if(res.data == 'ok'){
                    window.location.href = API + 'categories';
                }
                else {
                    document.querySelector('.mess__login').innerText = 'Tài khoản hoặc mật khẩu không chính xác';
                }
            }).catch(function (res){
                btnSubmit[0].classList.remove('submit-loadding');
                active__messageNotification("Có lỗi xảy ra hãy thử lại sau",false);
                console.log(res);
            });
        }
    }
});
