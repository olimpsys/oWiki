angular.module('owiki', ['ngRoute', 'ngCookies', 'ui.bootstrap', 'angular-loading-bar'])
        .config(function ($routeProvider) {
            $routeProvider
                    .when('/login', {
                        controller: 'LoginCtrl',
                        templateUrl: 'res/components/login/login.html'
                    })
                    .when('/dashboard', {
                        controller: 'DashboardCtrl',
                        templateUrl: 'res/components/dashboard/dashboard.html',
                        resolve: {
                            dashboard: function (apiSvc) {
                                return apiSvc.getDashboard().then(function (response) {
                                    return response.data;
                                }, function () {
                                    return false;
                                });
                            }
                        }
                    })
                    .when('/categories', {
                        controller: 'CategoriesCtrl',
                        templateUrl: 'res/components/category/categories.html',
                        resolve: {
                            categories: function (apiSvc) {
                                return apiSvc.getCategories('rootOnly').then(function (response) {
                                    return response.data.categories;
                                }, function () {
                                    return false;
                                });
                            }
                        }
                    })
                    .when('/category/:id', {
                        controller: 'CategoryCtrl',
                        templateUrl: 'res/components/category/category.html',
                        resolve: {
                            category: function ($route, apiSvc) {
                                return apiSvc.getCategory($route.current.params.id).then(function (response) {
                                    return response.data;
                                }, function () {
                                    return false;
                                });
                            }
                        }
                    })
                    .when('/users', {
                        controller: 'UsersCtrl',
                        templateUrl: 'res/components/user/users.html',
                        resolve: {
                            users: function (apiSvc) {
                                return apiSvc.getUsers().then(function (response) {
                                    return response.data.users;
                                }, function () {
                                    return false;
                                });
                            }
                        }
                    })
                    .when('/user/:id', {
                        controller: 'UserCtrl',
                        templateUrl: 'res/components/user/user.html',
                        resolve: {
                            user: function ($route, apiSvc) {
                                return apiSvc.getUser($route.current.params.id).then(function (response) {
                                    return response.data;
                                }, function () {
                                    return false;
                                });
                            }
                        }
                    })
                    .when('/page/create', {
                        controller: 'PageCreateCtrl',
                        templateUrl: 'res/components/page/page-create.html',
                        resolve: {
                            categories: function (apiSvc) {
                                return apiSvc.getCategories('nested').then(function (response) {
                                    return response.data.categories;
                                }, function () {
                                    return false;
                                });
                            },
                            page: function () {
                                return {
                                    content: 'Page Content'
                                };
                            }
                        }
                    })
                    .when('/page/:id', {
                        controller: 'PageCtrl',
                        templateUrl: 'res/components/page/page.html',
                        resolve: {
                            page: function ($route, apiSvc) {
                                return apiSvc.getPage($route.current.params.id).then(function (response) {
                                    return response.data;
                                }, function () {
                                    return false;
                                });
                            }
                        }
                    })
                    .when('/page/:id/edit', {
                        controller: 'PageCreateCtrl',
                        templateUrl: 'res/components/page/page-create.html',
                        resolve: {
                            categories: function (apiSvc) {
                                return apiSvc.getCategories('nested').then(function (response) {
                                    return response.data.categories;
                                }, function () {
                                    return false;
                                });
                            },
                            page: function ($route, apiSvc) {
                                return apiSvc.getPage($route.current.params.id).then(function (response) {
                                    return response.data;
                                }, function () {
                                    return false;
                                });
                            }
                        }
                    })
                    .when('/search/:query', {
                        controller: 'SearchResultsCtrl',
                        templateUrl: 'res/components/search/search-results.html',
                        resolve: {
                            results: function ($route, apiSvc) {
                                return apiSvc.doSearch($route.current.params.query).then(function (response) {
                                    return response.data.results;
                                }, function () {
                                    return false;
                                });
                            }
                        }
                    })
                    .when('/admin', {
                        controller: 'AdminCtrl',
                        templateUrl: 'res/components/admin/admin-panel.html'
                    })
                    .when('/admin/user/create', {
                        controller: 'AdminUserCreateCtrl',
                        templateUrl: 'res/components/admin/user-create.html',
                        resolve: {
                            user: function () {
                                return false;
                            }
                        }
                    })
                    .when('/admin/user/:id/edit', {
                        controller: 'AdminUserCreateCtrl',
                        templateUrl: 'res/components/admin/user-create.html',
                        resolve: {
                            user: function ($route, apiSvc) {
                                return apiSvc.getUser($route.current.params.id).then(function (response) {
                                    return response.data;
                                }, function () {
                                    return false;
                                });
                            }
                        }
                    })
                    .when('/profile/edit', {
                        controller: 'AdminUserCreateCtrl',
                        templateUrl: 'res/components/admin/user-create.html',
                        resolve: {
                            user: function (apiSvc) {
                                return apiSvc.getUser().then(function (response) {
                                    return response.data;
                                }, function () {
                                    return false;
                                });
                            }
                        }
                    })
                    .otherwise({
                        redirectTo: '/'
                    });
        })

        .run(function ($rootScope, $location, userSvc) {

            $rootScope.$on("$routeChangeStart", function (event, next, current) {

                var parseOriginalPath = function (next) {
                    try {
                        var matches = next.originalPath.match(next.regexp);
                        var url = matches[0];

                        for (var i = 1; i < matches.length; i++) {
                            var match = matches[i];
                            var key = matches[i].substr(1);
                            url = url.replace(match, next.params[key]);
                        }

                        return url;
                    } catch (e) {
                        return next.originalPath;
                    }
                };
                

                //skip auth check for certain/unprotected pages
                this.skipLoginPaths = ['/login'];

                if (this.skipLoginPaths.indexOf(next.originalPath) > -1) {
                    return;
                }

                //check if authenticated as user before continue or ask to login
                userSvc.getLoggedUser().then(function (user) {

                    if (!user) {

                        userSvc.redirectToLogin(parseOriginalPath(next));

                    } else {

                        $rootScope.user = user;

                        if (next.redirectTo == '/') {
                            $location.path("/dashboard");
                        }

                    }

                });

            });

            $rootScope.doLogout = function () {
                userSvc.doLogout();
                $location.path('/login').search({});
            };

        });