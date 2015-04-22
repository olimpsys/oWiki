angular.module('owiki')
        .controller('SearchResultsCtrl', function ($scope, $routeParams, results) {

            $scope.query = $routeParams.query;
            $scope.results = results;

        })
        .filter('boldHighlight', function ($sce) {
            return function (text, phrase) {
                if (phrase)
                    text = text.replace(new RegExp('(' + phrase + ')', 'gi'),
                            '<strong>$1</strong>');

                return $sce.trustAsHtml(text);
            };
        });