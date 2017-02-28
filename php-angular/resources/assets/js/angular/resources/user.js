angular.module('codetest').factory('UserService', ['$resource', function($resource) {

    return $resource('/user/:id', {
    });

}]);