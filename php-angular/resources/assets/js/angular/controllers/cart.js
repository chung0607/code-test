angular.module('codetest').controller('CartController', function($scope, CartItemService) {

    $scope.cartItems = [];
    var self = this;

    $scope.deleteCartItem = function(id) {
        CartItemService.delete({id: id}, function() {
            self._getCartItems();
        });
    }

    $scope.updateQuantity = function(carItemId, index) {
        var quantity = document.getElementsByName('quantity')[index].value;
        CartItemService.save({
            'id': carItemId,
            quantity: quantity,
        }, function() {

        });
    }

    this._getCartItems = function() {
        CartItemService.query().$promise.then(function(cartItems) {
            $scope.cartItems = cartItems;
        });
    }

    this._init = function() {
        this._getCartItems();
    }

    this._init();

});