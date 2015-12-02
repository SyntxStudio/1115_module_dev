<!DOCTYPE html>
<!-- /**
 * Created by PhpStorm.
 * User: Petar
 * Date: 24.10.2015
 * Time: 7:24
 */ -->
<html ng-app='myApp'>
<head>
    <title>Angular</title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?php echo site_url('assets/css/bootstrap/b ootstrap.min.css')?>"/>
    <script src="<?php echo site_url('assets/js/libraries/jquery-2.1.4.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/libraries/angular/angular.min.js'); ?>"></script>
    <script src="<?php echo site_url('app/main.js'); ?>"></script>
</head>
<body>
    <h1>Dobrodosli</h1>
    <hr/>
    <div ng-controller="someController as some">
        <input type="text" ng-model="text.val"/>
        <p ng-show="some.flag">{{text.val}}</p>
    </div>
</body>
</html>
