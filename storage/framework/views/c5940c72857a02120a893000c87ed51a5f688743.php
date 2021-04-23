<?php $__env->startSection('home-title'); ?>
Master | Create Branch User
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>
<?php
use App\Http\Controllers\Controller;
?>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if(Session::has('message')): ?>
            <div class="alert alert-success alert-dismissable" id="sucMsgDiv">
                <i class="fa fa-check"></i>
                <b>Success! <?php echo e(Session::get('message')); ?></b>
            </div>
            <?php endif; ?>
            <?php if(Session::has('error')): ?>
            <div class="alert alert-danger alert-dismissable" id="failMsgDiv">
                <i class="fa fa-ban"></i>
                <b>Info! <?php echo e(Session::get('error')); ?></b>
            </div>
            <?php endif; ?>
        </div>			
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Branch User Listing</h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo e(URL::to('branch/create_branch_user_data/')); ?>" class="iframeLarge" ><button type="button" class="btn btn-warning"><i class="fa fa-plus"></i> Add Branch Admin</button></a>
                    </div>
                </div>
                <div class="box-body">

                    <div id="listingTable">
                        <?php if(is_object($layoutArr['custompaginatorres']) && count($layoutArr['custompaginatorres']) > 0): ?>
                        <div class="table-responsive printDiv">            
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>#</th>
                                    <th>Organization</th>
                                    <th>Branch Name</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <?php $trCnt = ($layoutArr['custompaginatorres']->perPage() * ($layoutArr['custompaginatorres']->currentPage() - 1)) + 1; ?>                
                                <?php $__currentLoopData = $layoutArr['custompaginatorres']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resKey=>$resVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                if($resVal->status == 1){
                                    $status = "N";
                                }else if($resVal->status == 0){
                                    $status = "Y";
                                }
                              ?>
                                <tr>
                                    <td><?php echo e($trCnt); ?></td>
                                    <td><?php echo e(Controller::getDisplayFieldName($resVal->t_organizations_id,'t_organizations',['organization_name'])); ?></td>
                                    <td><?php echo e(Controller::getDisplayFieldName($resVal->t_branch_details_id,'t_branch_details',['branch_name'])); ?></td>
                                    <td><?php echo e($resVal->full_name); ?></td>
                                    <td><?php echo e($resVal->email_id); ?></td>
                                    <td><?php echo e(Controller::getDisplayFieldName($resVal->role_id,'roles',['role_name'])); ?></td>
                                    <td><?php echo e($resVal->mobile_number); ?></td>
                                    <td><?php echo e($status); ?></td>
                                    <td class="text-center">							
                                        <a class="iframeLarge btn-sm" href="<?php echo e(URL::to('/branch/create_branch_user_data/'.base64_encode(base64_encode($resVal->id)))); ?>">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <?php if($resVal->status == 1): ?>
                                        <a class="btn-sm" title="Active Record" onclick="ActiveUser(<?php echo e($resVal->id); ?>)">
                                            <i class="fa fa-check-circle-o"></i>
                                        </a> 
                                        <?php endif; ?>
                                        <?php if($resVal->status == 0): ?>
                                        <a class="btn-sm" title="Deactive Record" onclick="DeActiveUser(<?php echo e($resVal->id); ?>)">
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
<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pathology\resources\views/branch/create_branch_user.blade.php ENDPATH**/ ?>