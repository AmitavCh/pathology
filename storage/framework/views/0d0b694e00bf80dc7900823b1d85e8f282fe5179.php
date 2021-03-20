<?php $__env->startSection('home-title'); ?>
Master | Role Management
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>
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
            <div class="box box">
                <div class="box-body">
                    <form method="post" id="entryFrm" name="entryFrm">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="id" class="form-control" id="id" >
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group margine10bot">
                                    <label for="course_name"><span class="formError">*</span>Role Name</label>
                                    <input type="text" name="Role[role_name]" maxlength="25" class="form-control" id="role_name" autocomplete="off"/>
                                </div>
                            </div>
                        </div>						
                        <div class="box-footer">
                            <button type="button" onclick="saveRoleFrm();" class="btn btn-success">Save</button>
                            <button class="btn btn-warning" onclick="cancelFrm();" type="button">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>			
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.iframelightbox', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pathology\resources\views/master/add_role_data.blade.php ENDPATH**/ ?>