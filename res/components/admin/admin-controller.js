angular.module('owiki')
        .controller('AdminCtrl', function ($scope, apiSvc) {

        })
        .controller('AdminUserCreateCtrl', function ($window, $rootScope, $scope, $location, apiSvc, userSvc, user) {

            $scope.person = user;

            $scope.save = function () {

                $scope.isLoading = true;

                apiSvc.saveUser($scope.person.id, $scope.person.name, $scope.person.email, $scope.person.password, $scope.person.isAdmin, $scope.person.isActive)
                        .success(function (data) {

                            if ($rootScope.user.isAdmin) {
                                $location.path('/admin');
                            } else {
                                $location.path('/dashboard');
                            }

                            if ($rootScope.user.id == $scope.person.id) {
                                $window.location.reload();
                            }

                        })
                        .error(function (data, status) {
                            if (status == 401) {
                                userSvc.redirectToLogin($location.path());
                            } else {
                                $scope.isError = true;
                                $scope.errorMsg = data.error || 'An error occured. Please try again.';
                            }
                        })
                        .finally(function () {
                            $scope.isLoading = false;
                        });
            };
        });

