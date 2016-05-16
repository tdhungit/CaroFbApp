var app = angular.module('CaroFbApp', ['angularjs-facebook-sdk', 'ui.bootstrap'])

    .config(function facebookConfig(facebookConfigProvider) {
        facebookConfigProvider.setAppId(176587859036054);
        facebookConfigProvider.setOptions({ status: true });
    })
    .run(function (facebookConfig, facebookService) {
        facebookService.ready.then(function () {
            var statusChangeHandler = function (response) {
                if (response.status === 'connected') {
                    facebookService.api('/me').then(function (response) {
                        console.log(response);
                    });
                }
            };

            facebookService.Event.subscribe('auth.statusChange', statusChangeHandler);
        });
    })
    .controller('MarvelGuysController', function($scope, facebookService) {
        $scope.is_result = false;
        $scope.game_result = "";
        facebookService.ready.then(function () {
            var statusChangeHandler = function (response) {
                console.log(response);
                if (response.status === 'connected') {
                    $scope.game_result = "Bạn đích thị là 1 iron man đẹp trai, con nhà giàu, học giỏi rồi";
                    $scope.is_result = true;
                }
            };

            facebookService.Event.subscribe('auth.statusChange', statusChangeHandler);
        });
    })
;