angular.module('owiki')
        .service('userSvc', function ($rootScope, $q, $location, apiSvc) {

            this.hasLoggedUser = function () {
                return !!$rootScope.user;
            };

            this.getLoggedUser = function () {
                var accessToken = apiSvc.getAccessToken();
                var thissvc = this;

                if (!accessToken) {
                    return $q(function (resolve) {
                        resolve(false);
                    });
                } else {
                    if ($rootScope.user) {
                        return $q(function (resolve) {
                            resolve($rootScope.user);
                        });
                    } else {
                        return apiSvc.getUser().then(function (response) {
                            return response.data;
                        }, function () {
                            thissvc.doLogout();
                            return false;
                        });
                    }
                }
            };

            this.doLogin = function (username, password, remember) {

                return apiSvc.login(username, password).then(function (response) {
                    if (response.data.accesstoken) {
                        apiSvc.setAccessToken(response.data.accesstoken, remember);
                        return {success: true};
                    }
                    return {success: false};
                }, function (response) {
                    return {success: false, error: response.data.error, status: response.data.status};
                });

            };

            this.doLogout = function () {
                apiSvc.removeAccessToken();
            };

            this.redirectToLogin = function (redir) {
                $location
                        .path("/login")
                        .search((redir ? {redir: redir} : {}));
            };

        });