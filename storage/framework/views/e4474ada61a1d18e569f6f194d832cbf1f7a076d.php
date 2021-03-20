<?php $__env->startSection('home-title'); ?>
Master | Add User
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>
<?php
use App\Http\Controllers\Controller;
?>
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
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Pathology Details</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <form action="<?php echo e(url('user/saveUser')); ?>" method="post" role="form" id="entryFrm" enctype="multipart/form-data">
                    <input type="hidden" name="User[id]" class="form-control" id="id" >
                    <?php echo e(csrf_field()); ?>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Pathology Name</label>
                                <input type="text" name="User[fullname]" class="form-control" id="fullname" autocomplete="off">
                             </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Email Address</label>
                                <input type="text" name="User[email]" class="form-control" id="email" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name">Mobile Number</label>
                                <input type="text" name="User[mobile_number]" class="form-control" id="mobile_number"  autocomplete="off" >
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-4">
                            <div class="margine10bot">
                                <label for="exampleInputEmail1">Upload Logo</label>
                                <input name="image" type="file" id="logo" class="form-control" data-preview-file-type="any" multiple >								
                                <div id="app_photo_error"></div>
                                 <span><br>
                                    <?php if(isset($layoutArr['viewDataObj']->logo) && $layoutArr['viewDataObj']->logo != ''): ?>
                                    <div class="controls" id="filePreviewDv"> 
                                        <img src="<?php echo e(asset('public/user/orig/'.$layoutArr['viewDataObj']->logo)); ?>" height="100">
                                    </div>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                       
                    </div>
                    <div class="row">
                        
                        <div class="col-md-12">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name">Address</label>
                                <?php if(isset($layoutArr['viewDataObj']->address) && $layoutArr['viewDataObj']->address != ''): ?>
                                    <textarea type="text" name="User[address]" class="form-control" rows="2" id="address" autocomplete="off"><?php echo e($layoutArr['viewDataObj']->address); ?></textarea>
                                <?php else: ?>
                                    <textarea type="text" name="User[address]" class="form-control" rows="2" id="address" autocomplete="off"></textarea>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="button" onclick="userValidate();" class="btn btn-success">Save</button>
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
    var photo_name					=	'';
    var photo_size					=	'';
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
                    'upload_folder_name':'user',
                    'input_name_attr':'file_upload'
            }
        });

    });
    
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pathology\resources\views/setting/add_pathology_details.blade.php ENDPATH**/ ?>