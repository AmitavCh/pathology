<?php $__env->startSection('home-title'); ?>
Master | User Profile
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
<section class="content-header">
    <h1>User Setting</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> User Setting</a></li>
        <li><a href="#">Profile</a></li>
    </ol>
</section>
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
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Profile</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <form action="<?php echo e(url('user/updateProfile')); ?>" method="post" role="form" id="entryFrm" enctype="multipart/form-data">
                    <input type="hidden" name="id" class="form-control" id="id" >
                    <input type="hidden" name="formdata[photo_name]" class="form-control" id="photo_name" >    
                    <input type="hidden" name="formdata[photo_size]" class="form-control" id="photo_size" >    
                    <input type="hidden" name="formdata[photo_download_name]" class="form-control" id="photo_download_name" >
                    <?php echo e(csrf_field()); ?>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Email Address:</label>
                                <input type="text" name="formdata[email]" class="form-control" id="email" value="<?php echo e($layoutArr['userArr']->email); ?>" >  
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Full Name:</label>
                                <input type="text" name="formdata[fullname]" class="form-control" id="fullname" value="<?php echo e($layoutArr['userArr']->fullname); ?>" >
                             </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name">Mobile Number:</label>
                                <input type="text" name="formdata[mobile_number]" class="form-control" id="mobile_number" value="<?php echo e($layoutArr['userArr']->mobile_number); ?>" >
                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-sm-3">
                            <div class="form-group margine10bot">
                                <div>
                                    <label for="menu_name" class="text-block">Gender :</label>
                                </div>
                                <?php if(isset($layoutArr['userArr']->gender) && $layoutArr['userArr']->gender == 'Male'): ?>
                                <input checked="" class="form-controls" id="gender0" name="formdata[gender]" type="radio" value="1"/>Male
                                <?php else: ?>
                                <input class="form-controls" id="gender0" name="formdata[gender]" type="radio" value="0"/>Male
                                <?php endif; ?>
                                <?php if(isset($layoutArr['userArr']->gender) && $layoutArr['userArr']->gender == 'Female'): ?>
                                 <input checked="" class="form-controls" id="gender1" name="formdata[gender]" type="radio" value="1"/>Female
                                <?php else: ?>
                                <input class="form-controls" id="gender1" name="formdata[gender]" type="radio" value="0"/>Female
                                <?php endif; ?>
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
                                    <?php if(isset($layoutArr['userArr']->user_photo) && $layoutArr['userArr']->user_photo != ''): ?>
                                    <div class="controls" id="filePreviewDv"> 
                                        <img src="<?php echo e(asset('public/user/orig/'.$layoutArr['userArr']->user_photo)); ?>" height="100">
                                    </div>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name">Address:</label>
                                <textarea type="text" name="formdata[address]" class="form-control" rows="2" id="address"><?php echo e($layoutArr['userArr']->address); ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-success">Update</button>
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
            $("#user_photo").fileinput({ 
                uploadUrl: baseUrl+'/master/uploadImage',
                dropZoneTitle:'',
                showPreview:true,
                showRemove:false,
                showCancel:false,
                maxFileCount: 4,
                elErrorContainer:'#app_photo_error',
                <?php if(isset($layoutArr['viewDataObj']->user_photo)): ?>					
                    initialPreview: ["<img src='<% URL::to('/public/user/thumb/'.$layoutArr['viewDataObj']->user_photo) %>' id='file-preview'>"],		
                <?php endif; ?>
                uploadExtraData: {
                        'X-CSRF-Token': csrfTkn,
                        'upload_folder_name':'user',
                        'input_name_attr':'file_upload'
                }
            });
            		
        });
		function saveProfile(){
            $('.frmbtngroup').prop('disabled',true);			
            $('.error-message').remove();
            $('#sucMsgDiv').hide('slow');
            $('#failMsgDiv').hide('slow');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/user/updateProfile',
                type: 'post',
                cache: false,					
                data:{
                    "formdata": $('#entryFrm').serialize(),
                },
                success: function(res){
                    $('.frmbtngroup').prop('disabled',false);					
                    $.unblockUI();
                    var resp		=   res.split('****');
                    if(resp[1] == 'SUCCESS'){
                        resetFormVal('entryFrm',0);
                        $('.sucmsgdiv').html(resp[2]);
                        $('#sucMsgDiv').show('slow');
                        setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 5000);
                        window.location.replace(baseUrl+"/user/profile");
						showData(1);
                    }else if(resp[1] == 'FAILURE'){
                        showJsonErrors(resp[2]);																		
                    }else if(resp[1] == 'ERROR'){						
                        $('.failmsgdiv').html(resp[2]);
                        $('#failMsgDiv').show('slow');
                    }		
                },
                error: function(xhr, textStatus, thrownError) {
                    $.unblockUI();
                    $('.frmbtngroup').prop('disabled',false);
                    $('.failmsgdiv').html('Something went to wrong.Please Try again later...');
                    $('#failMsgDiv').show('slow');
                }
            });
        }
    
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pathology\resources\views/users/profile.blade.php ENDPATH**/ ?>