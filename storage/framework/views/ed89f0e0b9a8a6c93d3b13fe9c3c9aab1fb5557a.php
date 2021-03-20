<?php
$curRoute = Route::currentRouteAction();
$controller = '';
$action = '';
if ($curRoute != '') {
    if (strpos($curRoute, '@')) {
        $routePartArr = explode('@', $curRoute);
        if (isset($routePartArr) && is_array($routePartArr) && count($routePartArr) > 0) {
            if (isset($routePartArr[0])) {
                $controllerName = $routePartArr[0];
                $controllerNameArr = explode("/", str_replace('\\', '/', $controllerName));
                //print_r($controllerNameArr);
                $controller = $controllerNameArr[3];
            }
            if (isset($routePartArr[1])) {
                $action = $routePartArr[1];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en" style="background-image: url(http://localhost/pathology/public/bg.jpg);background-size: 1500px 750px;margin-top: -60px;">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $__env->yieldContent('home-title'); ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/bootstrap.min.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/font-awesome.min.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/adminlite.min.css')); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/js/plugins/iCheck/square/blue.css')); ?>">
    </head>
    <body class="login-page">
        <div class="login-box">
            <?php echo $__env->yieldContent('user-content'); ?>
        </div>
        <script src="<?php echo e(asset('public/js/plugins/jQuery/jQuery-2.1.4.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/js/bootstrap.min.js')); ?>"></script>
        <script src="<?php echo e(asset('public/js/plugins/iCheck/icheck.min.js')); ?>"></script>
        <?php echo $__env->make('includes/login-script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </body>

</html><?php /**PATH C:\xampp\htdocs\pathology\resources\views/layouts/login.blade.php ENDPATH**/ ?>