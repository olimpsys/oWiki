angular.module('owiki')
        .controller('PageCreateCtrl', function ($scope, $location, userSvc, apiSvc, categorySvc, categories, page) {

            $scope.isLoading = false;

            $scope.categories = categorySvc.parseCategories(categories);

            $scope.page = page;

            var editor = CKEDITOR.replace('pageContent');


            $scope.save = function () {

                //var id = $scope.page.id;
                //var title = $scope.page.title;
                var content = CKEDITOR.instances.pageContent.getData();
                //var categoryId = $scope.pageCategoryId;

                $scope.isLoading = true;

                apiSvc.savePage($scope.page.id, $scope.page.title, content, $scope.page.categoryId)
                        .success(function (data) {
                            $location.path('/page/' + data.page.id);
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

            $scope.deletePage = function () {

                if (confirm('Are you sure you want to delete this page permanently?')) {

                    $scope.isLoading = true;

                    apiSvc.deletePage($scope.page.id)
                            .success(function (data) {
                                $location.path('/category/' + $scope.page.categoryId);
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



        })

        .controller('PageCtrl', function ($scope, $sce, page) {

            $scope.page = page;
            $scope.pageContent = $sce.trustAsHtml($scope.page.content);

        });