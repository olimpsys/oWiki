angular.module('owiki')
        .controller('DashboardCtrl', function ($scope, dashboard) {

            $scope.recentPages = dashboard.recentPages;

        });