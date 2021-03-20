<?php $__env->startSection('home-title'); ?>
Master | User
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>
<?php
use App\Http\Controllers\Controller;
?>
<style>
    .file-drop-zone {
      height: auto;  
    }
    tr,td{
        padding-top: .5em;
        padding-bottom: .5em;
    }
    
    pre {

        display: block;
        padding: 0;
        margin: 0 0 10px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #333;
        word-break: break-all;
        word-wrap: break-word;
        background-color: transparent;
        border: transparent;
        border-radius: 4px;

    }

</style>
<?php 
    $total_photo_selected_cnt					=	0;
    $total_photo_uploaded_cnt					=	0;
    $photo_name									=	'';
    $photo_size									=	'';
?>
<section class="content-header">
    <h1>My Profile</h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-graduation-cap"></i> Employee</a></li>
        <li><a href="#">My Profile</a></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <?php 
                                if($viewDataObj->user_photo == ''){
                                ?>
                                <label for="exampleInputEmail1"><img src="<?php echo e(asset('public/uploads/public/item/orig/no.png')); ?>"  width="200" height="150"></label>
                                <?php }else{ ?>
                                <label for="exampleInputEmail1"><img src="<?php echo e(asset('public/user/orig/'.$viewDataObj->user_photo)); ?>"  width="200" height="150"></label>
                                <?php } ?>    
                            </div>
                            <div class="col-md-8">
                                <table style="width:100%">
                                    
                                </table>
                            </div>
                            <div class="col-md-1">
<!--                                <center><a class="btn btn-primary btn-small show-tooltip editLink" href="<% URL::to('/employee/changemyprofile/'.$viewDataObj->id); %>"><i class="fa fa-edit"></i></a></center>-->
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top:15px;">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab_1" data-toggle="tab"><b style="color:#0b3366">Personal Details</b></a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1">
                                        <table style="width:100%">
                                            <tr>
                                                <td width="5%"><b>Name : </b></td>
                                                <td width="20%"><?php echo e($viewDataObj->fullname); ?></td>
                                            </tr>
                                            <tr>
                                                <td width="5%"><b>Gender : </b></td>
                                                <td width="20%"><?php echo e($viewDataObj->gender); ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Mobile No  :</b></td>
                                                <td><?php echo e($viewDataObj->mobile_number); ?></td>
                                            </tr>
                                            <tr>
                                                <td><b>Email ID  :</b></td>
                                                <td><?php echo e($viewDataObj->email); ?></td>
                                            </tr>
                                                <td><b>Address :</b></td>
                                                <td><pre><?php echo e($viewDataObjs->address); ?></pre></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pathology\resources\views/users/userprofile.blade.php ENDPATH**/ ?>