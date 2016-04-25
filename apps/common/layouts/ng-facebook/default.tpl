<!DOCTYPE html>
<html lang="en" ng-app="CaroFbApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{ get_title() }}

    <!-- Bootstrap -->
    <link href="{{ static_url(theme_uri) }}/css/bootstrap.min.css" rel="stylesheet">

    <!-- AngularJS -->
    <script src="{{ static_url(theme_uri) }}/js/angular.min.js"></script>
    <script src="{{ static_url(theme_uri) }}/js/angular-animate.min.js"></script>
    <script src="{{ static_url(theme_uri) }}/js/angular-touch.min.js"></script>
    <script src="{{ static_url(theme_uri) }}/js/ui-bootstrap-tpls-1.3.2.min.js"></script>
    <script src="{{ static_url(theme_uri) }}/js/angularjs-facebook-sdk.min.js"></script>

    <!-- App -->
    <link href="{{ static_url(theme_uri) }}/css/style.css" rel="stylesheet">
    <script src="{{ static_url(theme_uri) }}/js/app.js"></script>
</head>
<body>

    <div id="wrapper">
        {{ get_content() }}
    </div>

</body>
</html>