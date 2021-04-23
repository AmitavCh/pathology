<?php $__env->startSection('home-title'); ?>
Master | Create Menu
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Menu Listing</h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo e(URL::to('master/add_menu_data/')); ?>" class="iframeD" ><button type="button" class="btn btn-warning"><i class="fa fa-plus"></i> Add Menu</button></a>
                    </div>
                </div>
                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap">
                        <form  action="" method="get">
                            <div class="row">
                                <div class="col-md-3 margine10bot"> 
                                    <div class="form-group">
                                         <input type="text" name="search_menu_name" maxlength="25" class="form-control" id="search_menu_name" placeholder="Search by menu name" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="col-md-1 margine10bot">
                                    <div class="form-group">
                                        <span class="form-group-btn">
                                            <button type="submit" class="btn btn-md btn-info"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="listingTable">
                        <?php if(is_object($layoutArr['custompaginatorres']) && count($layoutArr['custompaginatorres']) > 0): ?>	
                        <div class="table-responsive">            
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>#</th>
                                    <th>Menu Name</th>
                                    <th>Menu Order</th>
                                    <th>Menu Icon</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <?php $trCnt = 1; ?>                
                                <?php $__currentLoopData = $layoutArr['custompaginatorres']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resKey=>$resVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($trCnt); ?></td>
                                    <td><?php echo e($resVal->menu_name); ?></td>
                                    <td><?php echo e($resVal->menu_order); ?></td>
                                    <td><?php echo e($resVal->menu_icon); ?></td>
                                    <td class="text-center">							
                                        <a class="iframeD btn-sm" title="Edit Record" href="<?php echo e(URL::to('master/add_menu_data/'.base64_encode(base64_encode($resVal->id)))); ?>">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <?php if($resVal->is_active == 1): ?>
                                        <a class="btn-sm" title="Active Record" onclick="ActiveMenu(<?php echo e($resVal->id); ?>)">
                                            <i class="fa fa-check-circle-o"></i>
                                        </a> 
                                        <?php endif; ?>
                                        <?php if($resVal->is_active == 0): ?>
                                        <a class="btn-sm" title="Deactive Record" onclick="DeActiveMenu(<?php echo e($resVal->id); ?>)">
                                            <i class="fa fa-exclamation-triangle"></i>
                                        </a> 
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php $trCnt++; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </table>           
                        </div>
                        <?php if(count($layoutArr['custompaginatorres']) > 0): ?>
                        <?php echo e($layoutArr['custompaginatorres']->appends($layoutArr['sortFilterArr'])->links('')); ?>

                        <?php endif; ?>
                        <?php else: ?>            
                        <div class="alert alert-info">
                            <i class="fa fa-info"></i>No data found.
                        </div>
                        <?php endif; ?>
                    </div>
                </div>	
            </div>
        </div>			
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pathology\resources\views/master/add_menu.blade.php ENDPATH**/ ?>