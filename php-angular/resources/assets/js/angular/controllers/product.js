angular.module('codetest').controller('ProjectController', function($scope, ProductService) {

    $scope.products = [];
    var self = this;

    $scope.deleteProduct = function(id) {
        ProductService.delete({
            id: id,
        }).$promise.then(function() {
            self._getProducts();
        });
    }

    this._getProducts = function() {
        ProductService.query().$promise.then(function(products) {
            $scope.products = products;
        });
    }

    this._init = function() {
        this._getProducts();
    }

    this._init();

});