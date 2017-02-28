angular.module('codetest').factory('CartItemService', ['$resource', function($resource) {

    return $resource('/cart_item/:id', {
        id: '@id',
    });

}]);