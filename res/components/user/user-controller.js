angular.module('owiki')
        .controller('UsersCtrl', function ($scope, users) {

            $scope.users = users;

        })
        
        .controller('UserCtrl', function ($scope, user) {

            $scope.person = user;

        });