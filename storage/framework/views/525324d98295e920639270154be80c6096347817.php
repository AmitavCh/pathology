<?php

use App\Http\Controllers\Controller;

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
$menuSubMenuArr = Controller::getMenuSubmenu();
$roleMenuArrArr = Controller::getRoleMenuAdminLeftPane();
//echo'<pre>';print_r($menuSubMenuArr);echo'</pre>';
?>
<aside class="main-sidebar">
    <section class="sidebar">
        <?php if(is_array($menuSubMenuArr) && count($menuSubMenuArr) > 0): ?>			
        <ul class="sidebar-menu">
            <?php $__currentLoopData = $menuSubMenuArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuKey=>$menuVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>					
                <?php if(is_array($menuVal['submenus']) && count($menuVal['submenus']) > 0): ?>							
                    <?php if(isset($roleMenuArrArr['editMenuList']) && is_array($roleMenuArrArr['editMenuList']) && in_array($menuVal['id'],$roleMenuArrArr['editMenuList'])): ?>								
                    <li class="treeview <?php if($menuVal['controller'] == $controller): ?> active <?php endif; ?>">
                        <a href="javascript:void(0);" class="dropdown-toggle">	
                            <i class="<?php echo e($menuVal['menu_icon']); ?>"></i>
                            <span><?php echo e($menuVal['menu_name']); ?></span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>								
                        <ul class="treeview-menu">
                            <?php $__currentLoopData = $menuVal['submenus']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subMenuKey=>$subMenuVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(isset($roleMenuArrArr['editSubMenuList']) && is_array($roleMenuArrArr['editSubMenuList']) && in_array($subMenuVal['id'],$roleMenuArrArr['editSubMenuList'])): ?>
                                <li class="<?php if($subMenuVal['action'] == $action): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(URL::to($subMenuVal['sub_menu_url'])); ?>">												
                                        <i class="<?php echo e($subMenuVal['sub_menu_icon']); ?>"></i>
                                        <?php echo e($subMenuVal['sub_menu_name']); ?>

                                    </a>
                                </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                    <?php endif; ?>
                <?php else: ?>						
                    <?php if(isset($roleMenuArrArr['editMenuList']) && is_array($roleMenuArrArr['editMenuList']) && in_array($menuVal['id'],$roleMenuArrArr['editMenuList'])): ?>								
                    <li class="treeview <?php if($menuVal['controller'] == $controller): ?> active <?php endif; ?>">
                        <a href="<?php echo e(URL::to($menuVal['menu_url'])); ?>">
                            <i class="<?php echo e($menuVal['menu_icon']); ?>"></i>
                            <span><?php echo e($menuVal['menu_name']); ?></span>
                        </a>
                    </li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>					
        </ul>
        <?php endif; ?>
    </section>
</aside>


<?php /**PATH C:\xampp\htdocs\pathology\resources\views/elements/admin-leftpane.blade.php ENDPATH**/ ?>