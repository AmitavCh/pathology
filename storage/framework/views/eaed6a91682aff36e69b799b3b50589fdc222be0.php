<script>
var controller              =   '<?php echo e($controller); ?>';
var action                  =   '<?php echo e($action); ?>';
var baseUrl                 =   '<?php echo e(URL::to('/')); ?>';
var csrfTkn                 =   '<?php echo e(csrf_token()); ?> ';
var listingUrl				=	'';	
    function showJsonErrors(errors){	
        if(errors != ''){
            resp = $.parseJSON(errors);
            var totErrorLen = resp.length;	
            for(var errCnt =0;errCnt <totErrorLen;errCnt++){
                var modelField         =   resp[errCnt]['modelField'];
                var modelErrorMsg      =   resp[errCnt]['modelErrorMsg'];
                $('[id="'+modelField+'"]').after('<div class="error-message">'+modelErrorMsg+'</div>'); 
            }
        }
    }
    $(document).ready(function(){ 
        $('.datepicker').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
        });
        $('.datepkr').datetimepicker({                
            format: 'DD-MM-YYYY'
        }); 
		$(".datepkrNoRestrict").datetimepicker({
            format: 'DD-MM-YYYY',
		});
		$(".datepkrNoRestrict1").datepicker({
			format: 'dd-mm-yyyy',
			autoclose:true,
			startDate:new Date()
        });
        $(".datemask").inputmask("dd-mm-yyyy", {"placeholder": "dd-mm-yyyy"});
        $(".mobilemask").inputmask("999-999-9999");
        $(".phoneNoMask").inputmask("9999999999");
        $(".landMask").inputmask("(99999)-(9999999)");
        $(".pinMask").inputmask("999999");
        $(".adharMask").inputmask("9999999999999999");
		$(".timepicker").timepicker({
          showInputs: false
        });
        $(".iframe").colorbox({iframe:true,fixed:true, width:"900px", height:"600px",opacity:0.2,transition:'elastic'});
        $(".iframeD").colorbox({iframe:true,fixed:true, width:"500px", height:"500px",opacity:0.2,transition:'elastic'});
        $(".iframeLarge").colorbox({iframe:true,fixed:true, width:"90%", height:"90%",opacity:0.2,transition:'elastic'});
        $(".iframeSml").colorbox({iframe:true,fixed:true, width:"500px", height:"600px",opacity:0.2,transition:'elastic'});	
        $(".iframePrcentage").colorbox({iframe:true,fixed:true, width:"90%", height:"80%",opacity:0.2,transition:'elastic'});
        showData();
        
    });
    function goToCurPage(obj){
        $('#loddingImage').show();	
        $.ajax({
            url: $(obj).attr('href'),
            type: 'get',
            success:function(res){
                $('#listingTable').html(res);
                $('#loddingImage').hide();
                ajaxCompleteFunc();
            }
        });
        return false;
    }
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
        }
        return true;
    }
    function validateAlpha(evt){
        var keyCode = (evt.which) ? evt.which : evt.keyCode
        if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32){
            return false;
        }
            return true;
    }
    function cancelFrm(){
        <?php if($action == 'addRoleData'): ?>
            window.location.replace(baseUrl+"/master/add_role_data"); 
        <?php elseif($action == 'addMenuData'): ?>
            window.location.replace(baseUrl+"/master/add_menu_data"); 
        <?php elseif($action == 'addSubMenuData'): ?>
            window.location.replace(baseUrl+"/master/add_sub_menu_data"); 
        <?php elseif($action == 'addRoleMenu'): ?>
            window.location.replace(baseUrl+"/master/add_role_menu");
        <?php elseif($action == 'addUser'): ?>
            window.location.replace(baseUrl+"/master/add_user");
        <?php elseif($action == 'addEmpData'): ?>
            window.location.replace(baseUrl+"/setting/add_emp_data");    
        <?php elseif($action == 'addDepartment'): ?>
            window.location.replace(baseUrl+"/setting/add_department");
        <?php elseif($action == 'addDesignation'): ?>
            window.location.replace(baseUrl+"/setting/add_designation");
        <?php elseif($action == 'addOrganizationDetails'): ?>
            window.location.replace(baseUrl+"/setting/add_organization_details");
        <?php elseif($action == 'addState'): ?>
            window.location.replace(baseUrl+"/setting/add_state");
        <?php endif; ?>
    }
    function checkConfirmation(){
        if(confirm("Are you sure to Delete ?")){
            return true;
        }else{
            return false;
        }
    }
    function resetFormVal(frmId,hidVal){
        if(hidVal == 1){
            $('#'+frmId).find('input:hidden').val('');
        }else{
            $('#id').val('');
        }       
        $('#'+frmId).find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
        $('.'+frmId).find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
        $('#'+frmId).find('input:password,input:text, input:file, select, textarea').val('');   
        $('.'+frmId).find('input:password,input:text, input:file, select, textarea').val('');
        $('.error-message').remove();
    //resetting file upload content 
    }
    <?php if($action == 'addRoleData'): ?>
        function saveRoleFrm(){
            $('#sucMsgDiv').hide('slow');
            $('#failMsgDiv').hide('slow');                  
            $('#failMsgDiv').addClass('text-none');
            $('#sucMsgDiv').addClass('text-none');
            // $('.frmbtngroup').prop('disabled',true);            
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/master/saveRole',
                type: 'post',
                cache: false,                   
                data:{
                    "formdata": $('#entryFrm').serialize(),
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
                        setTimeout(function(){window.parent.location.reload(true);}, 1000);
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
    <?php endif; ?>    
    <?php if($action == 'addRole'): ?>
        function ActiveRole(record_id){
            if(confirm('Are you sure to Active Record ?')){
                $('#sucMsgDiv').hide('slow');
                $('#failMsgDiv').hide('slow');                  
                $('#failMsgDiv').addClass('text-none');
                $('#sucMsgDiv').addClass('text-none');
                // $('.frmbtngroup').prop('disabled',true);            
                $('#loddingImage').show();
                $.ajaxSetup({
                    headers: {
                            'X-CSRF-Token': csrfTkn
                    }
                });
                $.ajax({
                    url:baseUrl+'/master/roleActive',
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
                            window.location.replace(baseUrl+"/master/add_role"); 
                        }      
                    },
                    error: function(xhr, textStatus, thrownError) {
                        //alert('Something went to wrong.Please Try again later...');
                    }
                });
            }
        }
        function DeActiveRole(record_id){
            if(confirm('Are you sure to In-active Record ?')){
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
                    url:baseUrl+'/master/roleDeactive',
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
                            window.location.replace(baseUrl+"/master/add_role"); 
                        }      
                    },
                    error: function(xhr, textStatus, thrownError) {
                        //alert('Something went to wrong.Please Try again later...');
                    }
                });
            }
        }
    <?php endif; ?>
    <?php if($action == 'addMenuData'): ?>
        function saveMenuFrm(){
            $('#sucMsgDiv').hide('slow');
            $('#failMsgDiv').hide('slow');                  
            $('#failMsgDiv').addClass('text-none');
            $('#sucMsgDiv').addClass('text-none');
            // $('.frmbtngroup').prop('disabled',true);            
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/master/saveMenu',
                type: 'post',
                cache: false,                   
                data:{
                    "formdata": $('#entryFrm').serialize(),
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
                         setTimeout(function(){window.parent.location.reload(true);}, 1000);
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
    <?php endif; ?>
    <?php if($action == 'addMenu'): ?>
        function ActiveMenu(record_id){
            if(confirm('Are you sure to Active Record ?')){
                $('#sucMsgDiv').hide('slow');
                $('#failMsgDiv').hide('slow');                  
                $('#failMsgDiv').addClass('text-none');
                $('#sucMsgDiv').addClass('text-none');
                // $('.frmbtngroup').prop('disabled',true);            
                $('#loddingImage').show();
                $.ajaxSetup({
                    headers: {
                            'X-CSRF-Token': csrfTkn
                    }
                });
                $.ajax({
                    url:baseUrl+'/master/menuActive',
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
                            window.location.replace(baseUrl+"/master/add_menu"); 
                        }      
                    },
                    error: function(xhr, textStatus, thrownError) {
                        //alert('Something went to wrong.Please Try again later...');
                    }
                });
            }
        }
        function DeActiveMenu(record_id){
            if(confirm('Are you sure to In-active Record ?')){
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
                    url:baseUrl+'/master/menuDeactive',
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
                            window.location.replace(baseUrl+"/master/add_menu"); 
                        }      
                    },
                    error: function(xhr, textStatus, thrownError) {
                        //alert('Something went to wrong.Please Try again later...');
                    }
                });
            }
        }
    <?php endif; ?>
    <?php if($action == 'addSubMenu'): ?>
        function ActiveSubMenu(record_id){
            if(confirm('Are you sure to Active Record ?')){
                $('#sucMsgDiv').hide('slow');
                $('#failMsgDiv').hide('slow');                  
                $('#failMsgDiv').addClass('text-none');
                $('#sucMsgDiv').addClass('text-none');
                // $('.frmbtngroup').prop('disabled',true);            
                $('#loddingImage').show();
                $.ajaxSetup({
                    headers: {
                            'X-CSRF-Token': csrfTkn
                    }
                });
                $.ajax({
                    url:baseUrl+'/master/submenuActive',
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
                            window.location.replace(baseUrl+"/master/add_sub_menu"); 
                        }      
                    },
                    error: function(xhr, textStatus, thrownError) {
                        //alert('Something went to wrong.Please Try again later...');
                    }
                });
            }
        }
        function DeActiveSubMenu(record_id){
            if(confirm('Are you sure to In-active Record ?')){
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
                    url:baseUrl+'/master/submenuDeactive',
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
                            window.location.replace(baseUrl+"/master/add_sub_menu"); 
                        }      
                    },
                    error: function(xhr, textStatus, thrownError) {
                        //alert('Something went to wrong.Please Try again later...');
                    }
                });
            }
        }
    <?php endif; ?>
    <?php if($action == 'addSubMenuData'): ?>
        function saveSubMenuFrm(){
            $('#sucMsgDiv').hide('slow');
            $('#failMsgDiv').hide('slow');                  
            $('#failMsgDiv').addClass('text-none');
            $('#sucMsgDiv').addClass('text-none');
            // $('.frmbtngroup').prop('disabled',true);            
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/master/saveSubMenu',
                type: 'post',
                cache: false,                   
                data:{
                    "formdata": $('#entryFrm').serialize(),
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
                         setTimeout(function(){window.parent.location.reload(true);}, 1000);
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
    <?php endif; ?>
    <?php if($action == 'addRoleMenu'): ?>
        function getMenuSubmenu(role_id){
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/master/role-wise-menu',
                type: 'get',
                cache: false,
                //dataType: 'json',
                data:{
                    'role_id':role_id
                    //'role_id': $('#role_id').val()
                },
                success: function(res) {
                    $('#listingTable').html(res);
                    $('#loddingImage').hide();
                },
                error: function(xhr, textStatus, thrownError) {
                    $('#loddingImage').hide();
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
        function saveRoleMenuFrm(){
            $('#sucMsgDiv').hide('slow');
            $('#failMsgDiv').hide('slow');                  
            $('#failMsgDiv').addClass('text-none');
            $('#sucMsgDiv').addClass('text-none');
            // $('.frmbtngroup').prop('disabled',true);            
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/master/saveRoleMenu',
                type: 'post',
                cache: false,                   
                data:{
                    "formdata": $('#entryFrm').serialize(),
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
                        window.location.replace(baseUrl+"/master/add_role_menu"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
    <?php endif; ?>
    <?php if($action == 'addFeatures'): ?>
        function getMenuSubmenuList(role_id){
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/master/role_wise_menu_list',
                type: 'get',
                cache: false,
                //dataType: 'json',
                data:{},
                success: function(res) {
                    $('#listingTable').html(res);
                    $('#loddingImage').hide();
                },
                error: function(xhr, textStatus, thrownError) {
                    $('#loddingImage').hide();
                }
            });
        }
    <?php endif; ?>
    <?php if($action == 'changepassword'): ?>
        function saveUpdatePwd(){
            $('#sucMsgDiv').hide('slow');
            $('#failMsgDiv').hide('slow');                  
            $('#failMsgDiv').addClass('text-none');
            $('#sucMsgDiv').addClass('text-none');
            // $('.frmbtngroup').prop('disabled',true);            
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/user/updatePassword',
                type: 'post',
                cache: false,                   
                data:{
                    "formdata": $('#entryFrm').serialize(),
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
                        setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 8000);
                        window.location.replace(baseUrl+"/user/changepassword"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
    <?php endif; ?>
    <?php if($action == 'addDepartment'): ?>
        function saveDepartmentFrm(){
            $('#sucMsgDiv').hide('slow');
            $('#failMsgDiv').hide('slow');                  
            $('#failMsgDiv').addClass('text-none');
            $('#sucMsgDiv').addClass('text-none');
            // $('.frmbtngroup').prop('disabled',true);            
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/setting/saveDepartment',
                type: 'post',
                cache: false,                   
                data:{
                    "formdata": $('#entryFrm').serialize(),
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
                        setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 8000);
                        window.location.replace(baseUrl+"/setting/add_department"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
        function ActiveDepartment(record_id){
			if(confirm('Are you sure to Active Record ?')){
            $('#sucMsgDiv').hide('slow');
            $('#failMsgDiv').hide('slow');                  
            $('#failMsgDiv').addClass('text-none');
            $('#sucMsgDiv').addClass('text-none');
            // $('.frmbtngroup').prop('disabled',true);            
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/setting/departmentActive',
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
                        window.location.replace(baseUrl+"/setting/add_department"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
    }
        function DeActiveDepartment(record_id){
			if(confirm('Are you sure to In-active Record ?')){
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
                url:baseUrl+'/setting/departmentDeactive',
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
                        window.location.replace(baseUrl+"/setting/add_department"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
    }
        function DeleteDepartment(record_id){
            if(confirm('Are you sure to delete Data ?')){
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
                    url:baseUrl+'/setting/deleteDepartment',
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
                            window.location.replace(baseUrl+"/setting/add_department"); 
                        }      
                    },
                    error: function(xhr, textStatus, thrownError) {
                        //alert('Something went to wrong.Please Try again later...');
                    }
                });
            }
        }
    <?php endif; ?>
    <?php if($action == 'addDesignation'): ?>
        function saveDesignationFrm(){
            $('#sucMsgDiv').hide('slow');
            $('#failMsgDiv').hide('slow');                  
            $('#failMsgDiv').addClass('text-none');
            $('#sucMsgDiv').addClass('text-none');
            // $('.frmbtngroup').prop('disabled',true);            
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/setting/saveDesignation',
                type: 'post',
                cache: false,                   
                data:{
                    "formdata": $('#entryFrm').serialize(),
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
                        setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 8000);
                        window.location.replace(baseUrl+"/setting/add_designation"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
        function ActiveDesignation(record_id){
			if(confirm('Are you sure to Active Record ?')){
            $('#sucMsgDiv').hide('slow');
            $('#failMsgDiv').hide('slow');                  
            $('#failMsgDiv').addClass('text-none');
            $('#sucMsgDiv').addClass('text-none');
            // $('.frmbtngroup').prop('disabled',true);            
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/setting/designationActive',
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
                        window.location.replace(baseUrl+"/setting/add_designation"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
    }
        function DeActiveDesignation(record_id){
			if(confirm('Are you sure to In-active Record ?')){
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
                url:baseUrl+'/setting/designationDeactive',
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
                        window.location.replace(baseUrl+"/setting/add_designation"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
    }
        function DeleteDesignation(record_id){
            if(confirm('Are you sure to delete Data ?')){
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
                    url:baseUrl+'/setting/deleteDesignation',
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
                            window.location.replace(baseUrl+"/setting/add_designation"); 
                        }      
                    },
                    error: function(xhr, textStatus, thrownError) {
                        //alert('Something went to wrong.Please Try again later...');
                    }
                });
            }
        }
    <?php endif; ?>
    <?php if($action == 'addState'): ?>
        function saveState(){
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/setting/saveState',
                type: 'post',
                cache: false,                   
                data:{
                    "formdata": $('#entryFrm').serialize(),
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
                        setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 8000);
                        window.location.replace(baseUrl+"/setting/add_state"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
        function stateActive(record_id){
	if(confirm('Are you sure to Active Record ?')){
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/setting/stateActive',
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
                        window.location.replace(baseUrl+"/setting/add_state"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
    }
        function stateDeactive(record_id){
	if(confirm('Are you sure to In-active Record ?')){
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/setting/stateDeactive',
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
                        window.location.replace(baseUrl+"/setting/add_state"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
    }
    <?php endif; ?>
    <?php if($action == 'addCity'): ?>
        function saveCity(){
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/setting/saveCity',
                type: 'post',
                cache: false,                   
                data:{
                    "formdata": $('#entryFrm').serialize(),
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
                        setTimeout(function(){ $('#sucMsgDiv').fadeOut('slow'); }, 8000);
                        window.location.replace(baseUrl+"/setting/add_city"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
        function cityActive(record_id){
	if(confirm('Are you sure to Active Record ?')){
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/setting/cityActive',
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
                        window.location.replace(baseUrl+"/setting/add_city"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
        }
        function cityDeactive(record_id){
	if(confirm('Are you sure to In-active Record ?')){
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/setting/cityDeactive',
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
                        window.location.replace(baseUrl+"/setting/add_city"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
        }
    <?php endif; ?>
    function showData1(){
        <?php if($action == 'addRole'): ?>
            listingUrl                                                          =	baseUrl+'/master/roleListing';
            listingUrl								+=	'?role_name='+$('#role_name_listing').val();
        <?php endif; ?>
        <?php if($action == 'addFeatures'): ?>
            listingUrl                                                          =	baseUrl+'/master/roleWiseMenuList';
            listingUrl								+=	'?role_name='+$('#role_name_listing').val();
        <?php endif; ?>
        if(listingUrl != ''){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': csrfTkn
                }
            });
            $('#loddingImage').show();
            $.ajax({
                url:listingUrl,
                type: 'get',
                cache: false,			
                success: function(res) { 
                    $('#loddingImage').hide();
                    $('#listingTable').html(res);
                },
                error: function(xhr, textStatus, thrownError) {
                    $('#loddingImage').hide();
                }
            });
        }
    }
    function getCityList(selectedVal){
        $('#loddingImage').show();
        $.ajaxSetup({
            headers: {
                    'X-CSRF-Token': csrfTkn
                }
            });
        $.ajax({
            url:baseUrl+'/setting/citylist',
            type: 'post',
            cache: false,                   
            data:{
                "selectedVal": selectedVal,
            },
            success: function(res){     
                $('.error-message').remove();
                $('#loddingImage').hide();
                var resp   =   res;
                var options = '';
                   for(var x = 0; x < resp.length; x++) {
                       options += '<option value="' + resp[x]['id'] + '">' + resp[x]['name'] +'</option>';
                   }
                $("#t_cities_id").html(options);
                <?php if(isset($layoutArr['viewDataObj']->t_cities_id) && (int)$layoutArr['viewDataObj']->t_cities_id != 0): ?>
                    $('#t_cities_id').val(<?php echo e($layoutArr['viewDataObj']->t_cities_id); ?>);
                <?php endif; ?>
                },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
    }
    <?php if(isset($id) && $id != ''): ?>
        <?php if($action == 'addRegionalBranch'): ?>
            var id = <?php echo e($layoutArr['viewDataObj']->t_states_id); ?>

            getCityList(id);
        <?php endif; ?>
    <?php endif; ?>
    function printDiv(contElement){			
        var data	=	$('.'+contElement).html();
        var mywindow = window.open('', 'my div', 'height=400,width=800');
        mywindow.document.write('<html><head><title>my div</title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.print();
        mywindow.close();
        return true;
    }
    <?php if(isset($layoutArr['viewDataObj']) && is_object($layoutArr['viewDataObj'])): ?>
        <?php $__currentLoopData = $layoutArr['viewDataObj']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modelKey=>$modelVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            var elementId		=	"<?php echo e($modelKey); ?> ";// alert(elementId);
            var elementVal		=	"<?php echo e($modelVal); ?>";// alert(elementVal);
            if($('#'+elementId).length > 0){
                if(elementId != 'address'){
                    $('#'+elementId).val(elementVal);
                }
            }
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</script><?php /**PATH C:\xampp\htdocs\pathology\resources\views/includes/admin-script.blade.php ENDPATH**/ ?>