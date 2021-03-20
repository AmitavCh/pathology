<?php $__env->startSection('admin-content'); ?>  

<?php 
use App\Http\Controllers\Controller;
?>
    <?php if(is_array($layoutArr['menuSubMenuArr']) && count($layoutArr['menuSubMenuArr']) > 0): ?>
        <ul class="nav nav-pills nav-stacked">
            <?php $__currentLoopData = $layoutArr['menuSubMenuArr']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuKey=>$menuVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_object($menuVal) && $menuVal->count() > 0): ?>
                    <li>                                                                
                        <span><?php echo e(Controller::getDisplayFieldName($menuKey,'menus',['menu_name'])); ?></span>                                                                                            
                        <ul class="submenu">
                            <?php $__currentLoopData = $menuVal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subMenuKey=>$subMenuVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li style="list-style: none;">
                                    <?php if(in_array($subMenuVal->id,$layoutArr['editSubMenuList'])): ?>
                                        <input type="checkbox" name="subMenuIdArr[]" value="<?php echo e($subMenuVal->id); ?>" class="flat"/>
                                    <?php else: ?>
                                        <input type="checkbox" name="subMenuIdArr[]" value="<?php echo e($subMenuVal->id); ?>" class="flat" />
                                    <?php endif; ?>                                                                                      
                                    <?php echo e($subMenuVal->sub_menu_name); ?>                                          
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                <?php else: ?>
                    <li>
                        <?php if(in_array($menuKey,$layoutArr['editMenuList'])): ?>
                            <input type="checkbox" name="menuIdArr[]" value="<?php echo e($menuKey); ?>" class="flat"/>
                        <?php else: ?>
                            <input type="checkbox" name="menuIdArr[]" value="<?php echo e($menuKey); ?>" class="flat" />
                        <?php endif; ?>                                                                  
                        <span><?php echo e(Controller::getDisplayFieldName($menuKey,'menus',['menu_name'])); ?></span>                                
                    </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.ajax', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pathology\resources\views/master/role_wise_menu_list.blade.php ENDPATH**/ ?>