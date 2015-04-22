angular.module('owiki')
        .controller('CategoriesCtrl', function ($scope, $location, userSvc, apiSvc, categories) {

            $scope.categories = categories;
            $scope.isLoading = false;

            $scope.createCategory = function () {
                $scope.isLoading = true;

                var name = $scope.createCategoryName;

                apiSvc.saveCategory(name)
                        .success(function (response) {

                            $scope.categories.push(response.category);
                            $scope.createCategoryName = '';
                            $scope.addCatMode = false;

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

        })
        .controller('CategoryCtrl', function ($scope, $location, userSvc, apiSvc, categorySvc, category) {

            $scope.category = category;

            $scope.isLoading = false;
            $scope.isLoadingCategories = false;
            $scope.categories = false;

            $scope.createSubCategory = function () {
                $scope.isLoading = true;

                var name = $scope.createSubcategoryName;
                var parent = $scope.category.id;

                apiSvc.saveCategory(name, parent)
                        .success(function (response) {

                            $scope.category.categories.push(response.category);
                            $scope.createSubcategoryName = '';
                            $scope.addSubCatMode = false;

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

            $scope.saveCategory = function () {
                $scope.isLoading = true;

                apiSvc.saveCategory($scope.category.newName, $scope.category.parent, $scope.category.id)
                        .success(function (subcategory) {

                            $scope.category.name = $scope.category.newName;
                            $scope.editMode = false;

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

            $scope.deleteCategory = function () {
                if (confirm('Are you sure you want to delete this category, including all pages and subcategories?')) {

                    $scope.isLoading = true;

                    apiSvc.deleteCategory($scope.category.id)
                            .success(function (data) {
                                $location.path('/categories');
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

                }
            };

            $scope.loadCategories = function () {
                $scope.isLoadingCategories = true;
                apiSvc.getCategories('nested').success(function (data) {

                    $scope.categories = categorySvc.getUpperLevel(categorySvc.parseCategories(data.categories), $scope.category);

                }).error(function (data, status) {
                    if (status == 401) {
                        userSvc.redirectToLogin($location.path());
                    } else {
                        $scope.isError = true;
                        $scope.errorMsg = data.error || 'An error occured. Please try again.';
                    }
                }).finally(function () {
                    $scope.isLoadingCategories = false;
                });
            };

            $scope.$watch('editMode', function () {
                if ($scope.editMode && !$scope.isLoadingCategories && !$scope.categories) {
                    $scope.loadCategories();
                }
            });

        });