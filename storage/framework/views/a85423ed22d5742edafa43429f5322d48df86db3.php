<?php $__env->startSection('home-title'); ?>
Master | Change Password
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>
<?php
use App\Http\Controllers\Controller;
?>
<script src="<?php echo e(asset('public/js/jquery.min.js')); ?>"></script>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable" id="sucMsgDiv" style="display: none;">
                <i class="fa fa-check"></i>
                <b>Success!</b>
                <span class="sucmsgdiv"></span>					
            </div>
            <div class="alert alert-danger alert-dismissable" id="failMsgDiv" style="display: none;">
                <i class="fa fa-ban"></i>					
                <b>Info!</b>
                <span class="failmsgdiv"></span>
            </div>
        </div>			
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Change Password</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <form action="" method="post" role="form" id="entryFrm" enctype="multipart/form-data">
                    <input type="hidden" name="id" class="form-control" id="id" >
                    <?php echo e(csrf_field()); ?>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Old Password:</label>
                                <input type="text" name="formdata[ogr_password]" class="form-control" id="ogr_password" readonly="readonly" value="<?php echo e($layoutArr['userArr']->ogr_password); ?>" >  
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>New Password:</label>
                                <input type="text" name="formdata[password]" class="form-control" id="password" value="" autocomplete="off">
                             </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Confirm Password:</label>
                                <input type="text" name="formdata[re_password]" class="form-control" id="re_password" value="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                         <button type="button" onclick="saveUpdatePwd();" class="btn btn-success">Update</button>
                    </div>
                    </from>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pathology\resources\views/setting/changepassword.blade.php ENDPATH**/ ?>