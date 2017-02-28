angular.module('codetest').controller('IndexController', function($scope, ProductService, CartItemService) {

    $scope.products = [];
    $scope.category = 'all';

    var self = this;

    $scope.addToCart = function(productId, index) {
        var quantity = document.getElementsByName('quantity')[index].value;
        CartItemService.save({
            product_id: productId,
            quantity: quantity,
        }, function() {

        });
    }

    $scope.search = function() {
        self._getProducts();
    }

    this._getProducts = function() {
        ProductService.query({
            category    : $scope.category,
            keyword     : document.getElementsByName('keyword')[0].value,
        }).$promise.then(function(products) {
            $scope.products = products;
        });
    }

    $scope.init = function(category) {
        $scope.category = category;
        self._getProducts();
    }

});