angular.module('codetest').factory('ProductService', ['$resource', function($resource) {

    return $resource('/product/:id', {
    });

}]);