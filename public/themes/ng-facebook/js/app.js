var app = angular.module('CaroFbApp', ['angularjs-facebook-sdk', 'ui.bootstrap'])

    .config(function facebookConfig(facebookConfigProvider) {
        facebookConfigProvider.setAppId(176587859036054);
        facebookConfigProvider.setOptions({ status: false });
    })
    .run(function (facebookConfig, facebookService) {
        facebookService.ready.then(function () {
            console.log('Facebook is ready!');

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
    
;