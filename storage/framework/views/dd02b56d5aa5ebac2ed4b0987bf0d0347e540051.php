<?php
use App\Http\Controllers\Controller;
?>
<header class="main-header">
    <a href="<?php echo e(URL::to('/censor/dashboard')); ?>" class="logo">
        <span class="logo-mini"><b>Project Name</b></span>
        <span class="logo-lg">Project Name</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php if(isset(Auth::user()->user_photo) && Auth::user()->user_photo != ''): ?>
                        <img src="<?php echo e(asset('public/files/orig/'.Auth::user()->user_photo)); ?>" alt="Photo" class="user-image">
                        <?php else: ?>
                        <img src="<?php echo e(asset('public/img/no_image_autocpl.jpg')); ?>" alt="Photo" class="user-image">
                        <?php endif; ?>
                        <span class="hidden-xs">
                            <?php if(isset(Auth::user()->full_name) && Auth::user()->full_name != ''): ?>
                            <?php echo e(Auth::user()->full_name); ?>

                            <?php endif; ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <?php if(isset(Auth::user()->user_photo) && Auth::user()->user_photo != ''): ?>
                            <img src="<?php echo e(asset('public/files/orig/'.Auth::user()->user_photo)); ?>" alt="Photo" class="img-circle">
                            <?php else: ?>
                            <img src="<?php echo e(asset('public/img/no_image.jpg')); ?>" alt="Photo" class="img-circle">
                            <?php endif; ?>
                            <p>
                                <?php if(isset(Auth::user()->full_name)): ?>
                                Welcome <?php echo e(Auth::user()->full_name); ?>

                                <small><?php echo e(Controller::getRoleName(Auth::user()->role_id)); ?></small>
                                <?php endif; ?>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo e(URL::to('user/profile')); ?>" class="btn btn-success btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo e(URL::to('user/logout')); ?>" class="btn btn-success btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header><?php /**PATH C:\xampp\htdocs\pathology\resources\views/elements/admin-header.blade.php ENDPATH**/ ?>