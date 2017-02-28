angular.module('codetest').controller('UserController', function($scope, UserService) {

    $scope.users = [];
    var self = this;

    $scope.deleteUser = function(id) {
        UserService.delete({
            id: id,
        }).$promise.then(function() {
            self._getUsers();
        });
    }

    this._getUsers = function() {
        UserService.query().$promise.then(function(users) {
            $scope.users = users;
        });
    }

    this._init = function() {
        this._getUsers();
    }

    this._init();

});