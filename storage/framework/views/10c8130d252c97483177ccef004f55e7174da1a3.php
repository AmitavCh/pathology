<?php $__env->startSection('home-title'); ?>
Master | Menu Management
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
    pre {
        display: block;
        padding: 9.5px;
        margin: 0 0 10px;
        font-size: 13px;
        line-height: 1.42857143;
        color: #333;
        word-break: break-all;
        word-wrap: break-word;
        background-color: transparent;
        border: 1px solid transparent;
        border-radius: 4px;
        font-family: arial;
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
                    <form action="<?php echo e(url('branch/saveRegionalBranch')); ?>" method="post" role="form" id="entryFrm" enctype="multipart/form-data">
                    <input type="hidden" name="TBranchDetails[id]" class="form-control" id="id" >
                    <?php echo e(csrf_field()); ?>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Organization Name</label>
                                <select class="form-control" id="t_organizations_id" name="TBranchDetails[t_organizations_id]">
                                    <?php $__currentLoopData = $layoutArr['orgArr']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($menu['id']); ?>"><?php echo e($menu['name']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                             </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Branch Name</label>
                                <input type="text" name="TBranchDetails[branch_name]" class="form-control" id="branch_name" autocomplete="off" onkeypress="javascript : return validateAlpha(event);">
                             </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Email Address</label>
                                <input type="text" name="TBranchDetails[email_id]" class="form-control" id="email_id" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Contact Number</label>
                                <input type="text" name="TBranchDetails[mobile_number]" class="form-control" id="mobile_number"  autocomplete="off" onkeypress="javascript : return isNumberKey(event);">
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name">Other Contact Number</label>
                                <input type="text" name="TBranchDetails[other_mobile_number]" class="form-control" id="other_mobile_number"  autocomplete="off" onkeypress="javascript : return isNumberKey(event);">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>State Name</label>
                                <select class="form-control" id="t_states_id" name="TBranchDetails[t_states_id]" autocomplete="off" onChange='getCityList(this.value);'>
                                    <?php $__currentLoopData = $layoutArr['stateArr']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($menu['id']); ?>"><?php echo e($menu['name']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>City Name</label>
                                <select class="form-control" id="t_cities_id" name="TBranchDetails[t_cities_id]" autocomplete="off"/></select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Pin Code</label>
                                <input type="text" name="TBranchDetails[pin_code]" class="form-control" id="pin_code"  autocomplete="off" onkeypress="javascript : return isNumberKey(event);">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-6">
                            <div class="margine10bot">
                                <label for="exampleInputEmail1">Upload Logo</label>
                                <input name="image" type="file" id="logo" class="form-control" data-preview-file-type="any" multiple >								
                                <div id="app_photo_error"></div>
                                 <span><br>
                                    <?php if(isset($layoutArr['viewDataObj']->logo) && $layoutArr['viewDataObj']->logo != ''): ?>
                                    <div class="controls" id="filePreviewDv"> 
                                        <img src="<?php echo e(asset('public/files/orig/'.$layoutArr['viewDataObj']->logo)); ?>" height="100">
                                    </div>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Address</label>
                                <?php if(isset($layoutArr['viewDataObjs']->address) && $layoutArr['viewDataObjs']->address != ''): ?>
                                    <textarea type="text" name="TBranchDetails[address]" class="form-control" rows="3" id="address" autocomplete="off"><?php echo e($layoutArr['viewDataObjs']->address); ?></textarea>
                                <?php else: ?>
                                    <textarea type="text" name="TBranchDetails[address]" class="form-control" rows="3" id="address" autocomplete="off"></textarea>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <center><h4><b>Packages Details</b></h4></center>
                        <div class="col-md-12">
                            <div class="form-group margine10bot">
                                <div class="col-md-12">
                                <?php $__currentLoopData = $layoutArr['packagesArr']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-3" style="padding-bottom: 5px;">
                                <?php if(is_array($layoutArr['viewDataObj1']) && in_array($key,$layoutArr['viewDataObj1'])): ?>
                                <input type="checkbox" class="form-group" id="t_features_id" name="t_features_id[]" autocomplete="off" value="<?php echo e($key); ?>" checked>  <?php echo e($val); ?>

                                <?php else: ?>
                                <input type="checkbox" class="form-group" id="t_features_id" name="t_features_id[]" autocomplete="off" value="<?php echo e($key); ?>"/>  <?php echo e($val); ?>

                                <?php endif; ?>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="button" onclick="dataValidate();" class="btn btn-success">Save</button>
                        <button class="btn btn-warning" onclick="cancelFrm();" type="button">Cancel</button>
                    </div>
                    </from>
                </div>
            </div>
        </div>			
    </div>
</section>
<script>
    var photo_selected_cnt          =	0;
    var photo_name		    =	'';
    var photo_size		    =	'';
    var photo_download_name         =	'';
    $(document).ready(function(){
        $("#logo").fileinput({ 
            dropZoneTitle:'',
            showPreview:true,
            showRemove:false,
            showCancel:false,
            maxFileCount: 1,
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
<?php echo $__env->make('layouts.iframelightbox', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pathology\resources\views/branch/add_regional_branch_data.blade.php ENDPATH**/ ?>