@extends('layouts.admin-master')
@section('home-title')
Master | Organization
@endsection
@section('admin-content')
@php
use App\Http\Controllers\Controller;
@endphp
<link rel="stylesheet" type="text/css" href="{{asset('public/js/plugins/bootstrap-fileinput/fileinput.min.css')}}">
<script src="{{asset('public/js/jquery.min.js')}}"></script>
<script src="{{asset('public/js/plugins/bootstrap-fileinput/fileinput.min.js')}}"></script>
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
        background-color: #fff;
        border: 1px solid #fff;
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
            @if(Session::has('message'))
            <div class="alert alert-success alert-dismissable" id="sucMsgDiv">
                <i class="fa fa-check"></i>
                <b>Success! {{ Session::get('message') }}</b>
            </div>
            @endif
            @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissable" id="failMsgDiv">
                <i class="fa fa-ban"></i>
                <b>Info! {{ Session::get('error') }}</b>
            </div>
            @endif
        </div>			
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Organization Details</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <form action="{{ url('setting/saveOrganizationDetails') }}" method="post" role="form" id="entryFrm" enctype="multipart/form-data">
                    <input type="hidden" name="TOrganizations[id]" class="form-control" id="id" >
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Organization Name</label>
                                <input type="text" name="TOrganizations[organization_name]" class="form-control" id="organization_name" autocomplete="off" onkeypress="javascript : return validateAlpha(event);">
                             </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Email Address</label>
                                <input type="text" name="TOrganizations[email_id]" class="form-control" id="email_id" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Contact Number</label>
                                <input type="text" name="TOrganizations[mobile_number]" class="form-control" id="mobile_number"  autocomplete="off" onkeypress="javascript : return isNumberKey(event);">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name">Other Contact Number</label>
                                <input type="text" name="TOrganizations[mobile_number1]" class="form-control" id="mobile_number1"  autocomplete="off" onkeypress="javascript : return isNumberKey(event);">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name">Pan Number</label>
                                <input type="text" name="TOrganizations[mobile_number1]" class="form-control" id="mobile_number1"  autocomplete="off" onkeypress="javascript : return isNumberKey(event);">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name">GST Number</label>
                                <input type="text" name="TOrganizations[mobile_number1]" class="form-control" id="mobile_number1"  autocomplete="off" onkeypress="javascript : return isNumberKey(event);">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="margine10bot">
                                <label for="exampleInputEmail1">Upload Logo</label>
                                <input name="image" type="file" id="logo" class="form-control" data-preview-file-type="any" multiple >								
                                <div id="app_photo_error"></div>
                                 <span><br>
                                    @if(isset($layoutArr['viewDataObj']->logo) && $layoutArr['viewDataObj']->logo != '')
                                    <div class="controls" id="filePreviewDv"> 
                                        <img src="{{asset('public/files/orig/'.$layoutArr['viewDataObj']->logo)}}" height="100">
                                    </div>
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Address</label>
                                @if(isset($layoutArr['viewDataObjs']->address) && $layoutArr['viewDataObjs']->address != '')
                                    <textarea type="text" name="TOrganizations[address]" class="form-control" rows="3" id="address" autocomplete="off">{{$layoutArr['viewDataObjs']->address}}</textarea>
                                @else
                                    <textarea type="text" name="TOrganizations[address]" class="form-control" rows="3" id="address" autocomplete="off"></textarea>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="button" onclick="dataValidate();" class="btn btn-success">Save</button>
                        <button class="btn btn-warning" onclick="cancelFrm();" type="button">Cancel</button>
                    </div>
                    </from>
                </div>
                <div class="box-header">
                    <h3 class="box-title">Organization Listing</h3>
                </div>
                <div class="box-body">
                    
                    <div id="listingTable">
                        @if(is_object($layoutArr['custompaginatorres']) && count($layoutArr['custompaginatorres']) > 0)	
                        <div class="table-responsive">            
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>#</th>
                                    <th>Organization Name</th>
                                    <th>Email Id</th>
                                    <th>Mobile No.</th>
                                    <th>Logo</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <?php $trCnt = ($layoutArr['custompaginatorres']->perPage() * ($layoutArr['custompaginatorres']->currentPage() -1))+1;?>                
                                @foreach($layoutArr['custompaginatorres'] as $resKey=>$resVal)
                                <tr>
                                    <td>{{ $trCnt }}</td>
                                    <td>{{ $resVal->organization_name }}</td>
                                    <td>{{ $resVal->email_id }}</td>
                                    <td>{{ $resVal->mobile_number }}</td>
                                    <?php if($resVal->logo != ''){ ?>
                                    <td><img src="{{asset('public/files/orig/'.$resVal->logo)}}" height="100"></td>
                                    <?php }else{ ?>
                                    <td><img src="{{asset('public/no.png')}}" height="100"></td>
                                    <?php } ?>
                                    <td><pre>{{$resVal->address}}</pre></td>
                                    <td>{{$resVal->status}}</td>
                                    <td class="text-center">							
                                       						
                                        <a class="btn btn-primary btn-sm" href="{{ URL::to('setting/add_organization_details/'.base64_encode(base64_encode($resVal->id))) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @if($resVal->status == 'N')
                                        <a class="btn btn-success btn-sm" title="Active Record" onclick="organizationDetailsActive({{ $resVal->id }})">
                                            <i class="fa fa-check-circle-o"></i>
                                        </a> 
                                        @endif
                                        @if($resVal->status == 'Y')
                                        <a class="btn btn-warning btn-sm" title="Deactive Record" onclick="organizationDetailsDeactive({{ $resVal->id }})">
                                            <i class="fa fa-exclamation-triangle"></i>
                                        </a> 
                                        @endif
                                    
                                    </td>
                                </tr>
                                <?php $trCnt++; ?>
                                @endforeach
                            </table>           
                        </div>
                        @if(count($layoutArr['custompaginatorres']) > 0)
                        {{ $layoutArr['custompaginatorres']->appends('25')->links('') }}
                        @endif
                        @else            
                        <div class="alert alert-info">
                            <i class="fa fa-info"></i>No data found.
                        </div>
                        @endif
                    </div>
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
    function dataValidate(){
        $('.registerBtn').prop('disabled',true);
        $('.imgLoader').show();
        $('.error-message').remove();
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': csrfTkn
            }
        });
        $.ajax({
            url:baseUrl+'/setting/validateOrganizationDetails',
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
    function organizationDetailsActive(record_id){
        if(confirm('Are you sure to Active Record ?')){
            $('#loddingImage').show();
            $.ajaxSetup({
                headers: {
                        'X-CSRF-Token': csrfTkn
                }
            });
            $.ajax({
                url:baseUrl+'/setting/organizationDetailsActive',
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
                        window.location.replace(baseUrl+"/setting/add_organization_details"); 
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
                url:baseUrl+'/setting/organizationDetailsDeactive',
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
                        window.location.replace(baseUrl+"/setting/add_organization_details"); 
                    }      
                },
                error: function(xhr, textStatus, thrownError) {
                    //alert('Something went to wrong.Please Try again later...');
                }
            });
        }
    }
    
</script>
@stop