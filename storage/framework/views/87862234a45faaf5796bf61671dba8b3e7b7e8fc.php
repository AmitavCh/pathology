<?php $__env->startSection('home-title'); ?>
Master | Organization
<?php $__env->stopSection(); ?>
<?php $__env->startSection('admin-content'); ?>
<?php
use App\Http\Controllers\Controller;
?>
<style>
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
                    <h3 class="box-title">Organization Details Listing</h3>
                    <div class="box-tools pull-right">
                        <a href="<?php echo e(URL::to('master/add_organization_data/')); ?>" class="iframeLarge" ><button type="button" class="btn btn-warning"><i class="fa fa-plus"></i> Add Organization Details</button></a>
                    </div>
                </div>
                
                <div class="box-body">
                    
                    <div id="listingTable">
                        <?php if(is_object($layoutArr['custompaginatorres']) && count($layoutArr['custompaginatorres']) > 0): ?>	
                        <div class="table-responsive">            
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>#</th>
                                    <th>Organization Name</th>
                                    <th>Email Id</th>
                                    <th>Mobile No. / WhatsApp</th>
                                    <th>Contacts(LIMIT)</th>
                                    <th>Branches(LIMIT)</th>
                                    <th>Logo</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <?php $trCnt = ($layoutArr['custompaginatorres']->perPage() * ($layoutArr['custompaginatorres']->currentPage() -1))+1;?>                
                                <?php $__currentLoopData = $layoutArr['custompaginatorres']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resKey=>$resVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($trCnt); ?></td>
                                    <td><?php echo e($resVal->organization_name); ?></td>
                                    <td><?php echo e($resVal->email_id); ?></td>
                                    <td><?php echo e($resVal->mobile_number); ?></td>
                                    <td><?php echo e($resVal->points_of_contact); ?></td>
                                    <td><?php echo e($resVal->number_of_branch); ?></td>
                                    <?php if($resVal->logo != ''){ ?>
                                    <td><img src="<?php echo e(asset('public/files/orig/'.$resVal->logo)); ?>" height="100"></td>
                                    <?php }else{ ?>
                                    <td><img src="<?php echo e(asset('public/no.png')); ?>" height="100"></td>
                                    <?php } ?>
                                    <td><pre><?php echo e($resVal->address); ?></pre></td>
                                    <td><?php echo e($resVal->status); ?></td>
                                    <td class="text-center">							
                                       						
                                        <a class="iframeLarge btn-sm" title="Edit Record" href="<?php echo e(URL::to('master/add_organization_data/'.base64_encode(base64_encode($resVal->id)))); ?>">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <?php if($resVal->status == 'N'): ?>
                                        <a class="btn-sm" title="Active Record" onclick="organizationDetailsActive(<?php echo e($resVal->id); ?>)">
                                            <i class="fa fa-check-circle-o"></i>
                                        </a> 
                                        <?php endif; ?>
                                        <?php if($resVal->status == 'Y'): ?>
                                        <a class="btn-sm" title="Deactive Record" onclick="organizationDetailsDeactive(<?php echo e($resVal->id); ?>)">
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
                        <?php echo e($layoutArr['custompaginatorres']->appends('25')->links('')); ?>

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
    
    function organizationDetailsActive(record_id){
        if(confirm('Are you sure to Active Record ?')){
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/master/organizationDetailsActive',
                type: 'post',
                cache: false,                   
                data:{
                    "record_id": record_id,
                },
                success: function(res){     
                    $('.error-message').remove();
                    $('#loddingImage').hide();
                    var resp        =   res.split('****'); 
                    if(resp[1] == 'ERROR'){                                         
                        $('#failMsgDiv').removeClass('text-none');
                        $('.failmsgdiv').html(resp[2]);
                        $('#failMsgDiv').show('slow');
                    }else if(resp[1] == 'FAILURE'){
                        showJsonErrors(resp[2]);
                    }else if(resp[1] == 'SUCCESS'){
                        $('#sucMsgDiv').removeClass('text-none');
                        $('.sucmsgdiv').html(resp[2]);
                        $('#sucMsgDiv').show('slow');   
                        setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 5000);
                        window.location.replace(baseUrl+"/master/add_organization_details"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
    }
    function organizationDetailsDeactive(record_id){
        if(confirm('Are you sure to In-active Record ?')){
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/master/organizationDetailsDeactive',
                type: 'post',
                cache: false,                   
                data:{
                    "record_id": record_id,
                },
                success: function(res){     
                    $('.error-message').remove();
                    $('#loddingImage').hide();
                    var resp        =   res.split('****'); 
                    if(resp[1] == 'ERROR'){                                         
                        $('#failMsgDiv').removeClass('text-none');
                        $('.failmsgdiv').html(resp[2]);
                        $('#failMsgDiv').show('slow');
                    }else if(resp[1] == 'FAILURE'){
                        showJsonErrors(resp[2]);
                    }else if(resp[1] == 'SUCCESS'){
                        $('#sucMsgDiv').removeClass('text-none');
                        $('.sucmsgdiv').html(resp[2]);
                        $('#sucMsgDiv').show('slow');   
                        setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 5000);
                        window.location.replace(baseUrl+"/master/add_organization_details"); 
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
<?php echo $__env->make('layouts.admin-master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\pathology\resources\views/master/add_organization_details.blade.php ENDPATH**/ ?>