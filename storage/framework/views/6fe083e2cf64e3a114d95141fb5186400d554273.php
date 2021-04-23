<?php $__env->startSection('home-title'); ?>
Master | Master User
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/js/plugins/bootstrap-fileinput/fileinput.min.css')); ?>">
<script src="<?php echo e(asset('public/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('public/js/plugins/bootstrap-fileinput/fileinput.min.js')); ?>"></script>
<style>
    .file-preview {

        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 5px;
        width: 100%;
        margin-bottom: 5px;
        height: 266px;

    }
</style>
<?php
$total_photo_selected_cnt = 0;
$total_photo_uploaded_cnt = 0;
$photo_name = '';
$photo_size = '';
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if(Session::has('message')): ?>
            <div class="alert alert-success alert-dismissable" id="sucMsgDiv">
                <i class="fa fa-check"></i>
                <b>Success! <?php echo e(Session::get('message')); ?></b>
                <script>setTimeout(function(){window.parent.location.reload(true);}, 1000); </script>
            </div>
            <?php endif; ?>
            <?php if(Session::has('error')): ?>
            <div class="alert alert-danger alert-dismissable" id="failMsgDiv">
                <i class="fa fa-ban"></i>
                <b>Info! <?php echo e(Session::get('error')); ?></b>
                <script>setTimeout(function(){window.parent.location.reload(true);}, 2000); </script>
            </div>
            <?php endif; ?>
        </div>				
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body">
                    <form action="<?php echo e(url('master/saveMasterUserDetails')); ?>" method="post" role="form" id="entryFrm" enctype="multipart/form-data">
                        <input type="hidden" name="User[id]" class="form-control" id="id" >
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group margine10bot">
                                    <label for="inquiry_name"><span class="formError">*</span>Organization Name</label>
                                    <select class="form-control" id="t_organizations_id" name="User[t_organizations_id]">
                                        <?php $__currentLoopData = $layoutArr['orgArr']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($menu['id']); ?>"><?php echo e($menu['name']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group margine10bot">
                                    <label for="inquiry_name"><span class="formError">*</span>Full Name:</label>
                                    <input type="text" name="User[full_name]" class="form-control" id="full_name" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group margine10bot">
                                    <label for="inquiry_name"><span class="formError">*</span>Email Address:</label>
                                    <input type="text" name="User[email_id]" class="form-control" id="email_id" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group margine10bot">
                                    <label for="inquiry_name"><span class="formError">*</span>Mobile Number:</label>
                                    <?php if(isset($layoutArr['viewDataObj']->mobile_number) && $layoutArr['viewDataObj']->mobile_number != ''): ?>
                                    <input type="text" name="User[mobile_number]" class="form-control" id="mobile_number" value="<?php echo e($layoutArr['viewDataObj']->mobile_number); ?>" onkeypress="javascript : return isNumberKey(event);">
                                    <?php else: ?>
                                    <input type="text" name="User[mobile_number]" class="form-control" id="mobile_number" autocomplete="off" onkeypress="javascript : return isNumberKey(event);">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group margine10bot">
                                    <label for="inquiry_name"><span class="formError">*</span>AdharCard Number:</label>
                                    <?php if(isset($layoutArr['viewDataObj']->adhar_number) && $layoutArr['viewDataObj']->adhar_number != ''): ?>
                                    <input type="text" name="User[adhar_number]" class="form-control" id="adhar_number" value="<?php echo e($layoutArr['viewDataObj']->adhar_number); ?>" onkeypress="javascript : return isNumberKey(event);">
                                    <?php else: ?>
                                    <input type="text" name="User[adhar_number]" class="form-control" id="adhar_number" autocomplete="off" onkeypress="javascript : return isNumberKey(event);">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group margine10bot">
                                    <label for="inquiry_name">Alternate Mobile Number:</label>
                                    <?php if(isset($layoutArr['viewDataObj']->alter_mobile_number) && $layoutArr['viewDataObj']->alter_mobile_number != ''): ?>
                                    <input type="text" name="User[alter_mobile_number]" class="form-control" id="alter_mobile_number" value="<?php echo e($layoutArr['viewDataObj']->alter_mobile_number); ?>" onkeypress="javascript : return isNumberKey(event);">
                                    <?php else: ?>
                                    <input type="text" name="User[alter_mobile_number]" class="form-control" id="alter_mobile_number" autocomplete="off" onkeypress="javascript : return isNumberKey(event);">
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group margine10bot">
                                    <label for="course_name"><span class="formError">*</span> Role Name :</label>
                                    <select class="form-control" id="role_id" name="User[role_id]">
                                        <?php $__currentLoopData = $layoutArr['roleArr']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($role['id']); ?>"><?php echo e($role['name']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group margine10bot">
                                    <label for="inquiry_name"><span class="formError">*</span>Password:</label>
                                    <input type="password" name="User[ogr_password]" class="form-control" id="ogr_password"  autocomplete="off" >
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6 col-sm-6">
                                <div class="margine10bot">
                                    <label for="exampleInputEmail1">Profile Photo</label>
                                    <input name="image" type="file" id="user_photo" class="form-control" data-preview-file-type="any" multiple >								
                                    <div id="app_photo_error"></div>
                                    <div id="student_photo_valderror"></div>	
                                    <span><br>
                                        <?php if(isset($layoutArr['viewDataObj']->user_photo) && $layoutArr['viewDataObj']->user_photo != ''): ?>
                                        <div class="controls" id="filePreviewDv"> 
                                            <img src="<?php echo e(asset('public/files/orig/'.$layoutArr['viewDataObj']->user_photo)); ?>" height="100">
                                        </div>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group margine10bot">
                                    <label for="inquiry_name">Address:</label>
                                    <?php if(isset($layoutArr['viewDataObjs']->address) && $layoutArr['viewDataObjs']->address != ''): ?>
                                    <textarea type="text" name="User[address]" class="form-control" rows="2" id="address" autocomplete="off"><?php echo e($layoutArr['viewDataObjs']->address); ?></textarea>
                                    <?php else: ?>
                                    <textarea type="text" name="User[address]" class="form-control" rows="2" id="address" autocomplete="off"></textarea>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <?php if(isset($layoutArr['viewDataObj']->id) && $layoutArr['viewDataObj']->id != ''): ?>
                            <button type="button" onclick="userValidates();" class="btn btn-success">Save</button>
                            <?php else: ?>
                            <button type="button" onclick="userValidate();" class="btn btn-success">Save</button>
                            <?php endif; ?>
                            <button class="btn btn-warning" onclick="cancelFrm();" type="button">Cancel</button>
                        </div>
                        </from>
                </div>
            </div>
        </div>			
    </div>
</section>

<script>
    var photo_selected_cnt = 0;
    var photo_name = '';
    var photo_size = '';
    var photo_download_name = '';
    $(document).ready(function(){
        $("#user_photo").fileinput({
        uploadUrl: baseUrl + '/master/uploadImage',
                dropZoneTitle:'',
                showPreview:true,
                showRemove:false,
                showCancel:false,
                maxFileCount: 4,
                elErrorContainer:'#app_photo_error',
                uploadExtraData: {
                'X-CSRF-Token': csrfTkn,
                        'upload_folder_name':'files',
                        'input_name_attr':'file_upload'
                }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.iframelightbox', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pathology\resources\views/master/add_master_user_data.blade.php ENDPATH**/ ?>