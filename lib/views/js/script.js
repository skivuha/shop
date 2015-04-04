$( document ).ready(function() {
    console.log('hi');
    // insertInCart('/Cart/index/', 'get');
    $.ajax({
        url: '/Ajax/addQuantity/',
        method: 'GET'
   }).then(function (data) {
        var objJSON = JSON.parse(data);
    });
});

/*var app = angular.module('app', []);

app.controller('booksController', function($scope, $http) {
    getBooks(); // Load all available tasks


  function getBooks(){
        $http.post("/Cart/index/").success(function(data){
            $scope.books = data;
            return $scope.books;
        });
}
});*/