app.factory('book', function ($http) {
    return {
        getBook: function (callback) {
            $http.get('/Catr/index/').success(callback);
        }
    };
});