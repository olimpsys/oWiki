angular.module('owiki')
        .controller('LoginCtrl', function ($scope, $location, $routeParams, userSvc) {

            $scope.doLogin = function () {
                userSvc.doLogin($scope.username, $scope.password, $scope.remember).then(function (response) {
                    if (!response.success) {
                        $scope.isError = true;
                        $scope.errorMsg = response.error || 'An error occured. Please try again.';
                    } else {
                        $location.path($routeParams.redir || '/').search({});
                    }
                });
            };

        });