angular.module('owiki')
        .controller('LoginCtrl', function ($scope, $location, $routeParams, userSvc) {

            $scope.doLogin = function () {
                userSvc.doLogin($scope.username, $scope.password, $scope.remember).then(function (success) {
                    if (!success) {
                        $location.path('/login').search({});
                    } else {
                        $location.path($routeParams.redir || '/').search({});
                    }
                });
            };

        });