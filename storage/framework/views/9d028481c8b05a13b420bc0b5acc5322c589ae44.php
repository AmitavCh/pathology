<?php $__env->startSection('home-title'); ?>
User | Create Master User
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
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Create Master User</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <form action="<?php echo e(url('user/saveMasterUser')); ?>" method="post" role="form" id="entryFrm" enctype="multipart/form-data">
                        <input type="hidden" name="User[id]" class="form-control" id="id" >
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group margine10bot">
                                    <label for="inquiry_name"><span class="formError">*</span>Organization Name</label>
                                    <select class="form-control" id="t_organizations_id" name="User[t_organizations_id]">
                                        <?php $__currentLoopData = $layoutArr['orgArr']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($menu['id']); ?>"><?php echo e($menu['name']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group margine10bot">
                                    <label for="inquiry_name"><span class="formError">*</span>Branch Name</label>
                                    <select class="form-control" id="t_branch_details_id" name="User[t_branch_details_id]">
                                        <?php $__currentLoopData = $layoutArr['branchArr']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($menu['id']); ?>"><?php echo e($menu['name']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group margine10bot">
                                    <label for="inquiry_name"><span class="formError">*</span>Full Name:</label>
                                    <input type="text" name="User[full_name]" class="form-control" id="full_name" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                                    <input type="text" name="User[mobile_number]" class="form-control" id="mobile_number" value="<?php echo e($layoutArr['viewDataObj']->mobile_number); ?>">
                                    <?php else: ?>
                                    <input type="text" name="User[mobile_number]" class="form-control" id="mobile_number" autocomplete="off">
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
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">					
                <div class="box-header">
                    <h3 class="box-title">User Listing</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>							
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
                                    <th>Branch</th>
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
                                        <a class="btn btn-primary btn-sm" href="<?php echo e(URL::to('user/add_user/'.base64_encode(base64_encode($resVal->id)))); ?>">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <?php if($resVal->status == 1): ?>
                                        <a class="btn btn-success btn-sm" title="Active Record" onclick="ActiveUser(<?php echo e($resVal->id); ?>)">
                                            <i class="fa fa-check-circle-o"></i>
                                        </a> 
                                        <?php endif; ?>
                                        <?php if($resVal->status == 0): ?>
                                        <a class="btn btn-warning btn-sm" title="Deactive Record" onclick="DeActiveUser(<?php echo e($resVal->id); ?>)">
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
    function userValidate(){
        $('.registerBtn').prop('disabled',true);
        $('.imgLoader').show();
        $('.error-message').remove();
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': csrfTkn
            }
        });
        $.ajax({
            url:baseUrl+'/user/validateMasterUser',
            type: 'post',
            cache: false,
            data:{
                "formData": $('#entryFrm').serialize(),
            },
            success: function(res){
                $('.imgLoader').hide();
                var resp	=   res.split('****');
                if(resp[1] == 'ERROR'){
                    $('.registerBtn').prop('disabled',false);
                }else{
                    if(resp[1] == 'FAILURE'){
                        $('.btn btn-success').prop('disabled',false);
                       showJsonErrors(resp[2]);
                    }else if(resp[1] == 'SUCCESS'){
                        document.forms['entryFrm'].submit();
                    }
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
    }
    function userValidates(){
        $('.registerBtn').prop('disabled',true);
        $('.imgLoader').show();
        $('.error-message').remove();
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': csrfTkn
            }
        });
        $.ajax({
            url:baseUrl+'/user/validateMasterUsers',
            type: 'post',
            cache: false,
            data:{
                "formData": $('#entryFrm').serialize(),
            },
            success: function(res){
                $('.imgLoader').hide();
                var resp	=   res.split('****');
                if(resp[1] == 'ERROR'){
                    $('.registerBtn').prop('disabled',false);
                }else{
                    if(resp[1] == 'FAILURE'){
                        $('.btn btn-success').prop('disabled',false);
                       showJsonErrors(resp[2]);
                    }else if(resp[1] == 'SUCCESS'){
                        document.forms['entryFrm'].submit();
                    }
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
    }
    function ActiveUser(record_id){
        if (confirm('Are you sure to Active Record ?')){
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl + '/user/userActive',
                type: 'post',
                cache: false,
                data:{
                    "record_id": record_id,
                },
                success: function(res){
                $('.error-message').remove();
                $('#loddingImage').hide();
                var resp = res.split('****');
                if (resp[1] == 'ERROR'){
                $('#failMsgDiv').removeClass('text-none');
                $('.failmsgdiv').html(resp[2]);
                $('#failMsgDiv').show('slow');
                } else if (resp[1] == 'FAILURE'){
                showJsonErrors(resp[2]);
                } else if (resp[1] == 'SUCCESS'){
                $('#sucMsgDiv').removeClass('text-none');
                $('.sucmsgdiv').html(resp[2]);
                $('#sucMsgDiv').show('slow');
                setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 5000);
                window.location.replace(baseUrl + "/user/add_user");
                }
                },
                error: function(xhr, textStatus, thrownError) {
                //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
    }
    function DeActiveUser(record_id){
    if (confirm('Are you sure to In-active Record ?')){
    $('#sucMsgDiv').hide('slow');
    $('#failMsgDiv').hide('slow');
    $('#failMsgDiv').addClass('text-none');
    $('#sucMsgDiv').addClass('text-none');
    $('#loddingImage').show();
    $.ajaxSetup({
    headers: {
    'X-CSRF-Token': csrfTkn
    }
    });
    $.ajax({
    url:baseUrl + '/user/userDeactive',
            type: 'post',
            cache: false,
            data:{
            "record_id": record_id,
            },
            success: function(res){
            $('.error-message').remove();
            $('#loddingImage').hide();
            var resp = res.split('****');
            if (resp[1] == 'ERROR'){
            $('#failMsgDiv').removeClass('text-none');
            $('.failmsgdiv').html(resp[2]);
            $('#failMsgDiv').show('slow');
            } else if (resp[1] == 'FAILURE'){
            showJsonErrors(resp[2]);
            } else if (resp[1] == 'SUCCESS'){
            $('#sucMsgDiv').removeClass('text-none');
            $('.sucmsgdiv').html(resp[2]);
            $('#sucMsgDiv').show('slow');
            setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 5000);
            window.location.replace(baseUrl + "/user/add_user");
            }
            },
            error: function(xhr, textStatus, thrownError) {
            //alert('Something went to wrong.Please Try again later...');
            }
    });
    }
    }

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pathology\resources\views/users/add_user.blade.php ENDPATH**/ ?>