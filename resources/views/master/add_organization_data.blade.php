@extends('layouts.iframelightbox')
@section('home-title')
Master | Add Organization
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
                <script>setTimeout(function(){window.parent.location.reload(true);}, 1000); </script>
            </div>
            @endif
            @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissable" id="failMsgDiv">
                <i class="fa fa-ban"></i>
                <b>Info! {{ Session::get('error') }}</b>
                <script>setTimeout(function(){window.parent.location.reload(true);}, 2000); </script>
            </div>
            @endif
        </div>			
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body">
                    <form action="{{ url('master/saveOrganizationDetails') }}" method="post" role="form" id="entryFrm" enctype="multipart/form-data">
                    <input type="hidden" name="TOrganizations[id]" class="form-control" id="id" >
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Organization Name</label>
                                @if(isset($layoutArr['viewDataObj']->organization_name) && $layoutArr['viewDataObj']->organization_name != '')
                                    <input type="text" name="TOrganizations[organization_name]" class="form-control" id="organization_name"  autocomplete="off" onkeypress="javascript : return validateAlpha(event);" value="{{$layoutArr['viewDataObj']->organization_name}}">
                                @else
                                    <input type="text" name="TOrganizations[organization_name]" class="form-control" id="organization_name"  autocomplete="off" onkeypress="javascript : return validateAlpha(event);">
                                @endif
                             </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Email Address</label>
                                @if(isset($layoutArr['viewDataObj']->email_id) && $layoutArr['viewDataObj']->email_id != '')
                                    <input type="text" name="TOrganizations[email_id]" class="form-control" id="email_id"  autocomplete="off" value="{{$layoutArr['viewDataObj']->email_id}}">
                                @else
                                    <input type="text" name="TOrganizations[email_id]" class="form-control" id="email_id"  autocomplete="off">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Mobile Number / WhatsApp Number</label>
                                @if(isset($layoutArr['viewDataObj']->mobile_number) && $layoutArr['viewDataObj']->mobile_number != '')
                                    <input type="text" name="TOrganizations[mobile_number]" class="form-control" id="mobile_number"  autocomplete="off" value="{{$layoutArr['viewDataObj']->email_id}}" onkeypress="javascript : return isNumberKey(event);">
                                @else
                                    <input type="text" name="TOrganizations[mobile_number]" class="form-control" id="mobile_number"  autocomplete="off">
                                @endif
                             </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name">Land Line Number</label>
                                @if(isset($layoutArr['viewDataObj']->alter_mobile_number) && $layoutArr['viewDataObj']->alter_mobile_number != '')
                                    <input type="text" name="TOrganizations[alter_mobile_number]" class="form-control" id="alter_mobile_number"  autocomplete="off" value="{{$layoutArr['viewDataObj']->email_id}}" onkeypress="javascript : return isNumberKey(event);">
                                @else
                                    <input type="text" name="TOrganizations[alter_mobile_number]" class="form-control" id="alter_mobile_number"  autocomplete="off">
                                @endif
                             </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Pan Number</label>
                                @if(isset($layoutArr['viewDataObj']->pan_number) && $layoutArr['viewDataObj']->pan_number != '')
                                    <input type="text" name="TOrganizations[pan_number]" class="form-control" id="pan_number"  autocomplete="off" value="{{$layoutArr['viewDataObj']->pan_number}}">
                                @else
                                    <input type="text" name="TOrganizations[pan_number]" class="form-control" id="pan_number"  autocomplete="off">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>GST Number</label>
                                @if(isset($layoutArr['viewDataObj']->gst_number) && $layoutArr['viewDataObj']->gst_number != '')
                                    <input type="text" name="TOrganizations[gst_number]" class="form-control" id="gst_number"  autocomplete="off" value="{{$layoutArr['viewDataObj']->gst_number}}">
                                @else
                                    <input type="text" name="TOrganizations[gst_number]" class="form-control" id="gst_number"  autocomplete="off">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Points Of Contacts(LIMIT)</label>
                                @if(isset($layoutArr['viewDataObj']->points_of_contact) && $layoutArr['viewDataObj']->points_of_contact != '')
                                    <input type="text" name="TOrganizations[points_of_contact]" class="form-control" id="points_of_contact"  autocomplete="off" onkeypress="javascript : return isNumberKey(event);" value="{{$layoutArr['viewDataObj']->points_of_contact}}">
                                @else
                                    <input type="text" name="TOrganizations[points_of_contact]" class="form-control" id="points_of_contact"  autocomplete="off" onkeypress="javascript : return isNumberKey(event);">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Number Of Branches(LIMIT)</label>
                                @if(isset($layoutArr['viewDataObj']->number_of_branch) && $layoutArr['viewDataObj']->number_of_branch != '')
                                    <input type="text" name="TOrganizations[number_of_branch]" class="form-control" id="number_of_branch"  autocomplete="off" onkeypress="javascript : return isNumberKey(event);" value="{{$layoutArr['viewDataObj']->number_of_branch}}">
                                @else
                                    <input type="text" name="TOrganizations[number_of_branch]" class="form-control" id="number_of_branch"  autocomplete="off" onkeypress="javascript : return isNumberKey(event);">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                    <div class="row">
                        <center><h4><b>Bank Accounts Details</b></h4></center>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Bank Name</label>
                                @if(isset($layoutArr['viewDataObj']->bank_name) && $layoutArr['viewDataObj']->bank_name != '')
                                    <input type="text" name="TOrganizations[bank_name]" class="form-control" id="bank_name"  autocomplete="off" onkeypress="javascript : return validateAlpha(event);" value="{{$layoutArr['viewDataObj']->bank_name}}">
                                @else
                                    <input type="text" name="TOrganizations[bank_name]" class="form-control" id="bank_name"  autocomplete="off">
                                @endif
                             </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name">Branch Name</label>
                                @if(isset($layoutArr['viewDataObj']->branch_name) && $layoutArr['viewDataObj']->branch_name != '')
                                    <input type="text" name="TOrganizations[branch_name]" class="form-control" id="branch_name"  autocomplete="off" onkeypress="javascript : return validateAlpha(event);" value="{{$layoutArr['viewDataObj']->branch_name}}">
                                @else
                                    <input type="text" name="TOrganizations[branch_name]" class="form-control" id="branch_name"  autocomplete="off">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>IFSC Code</label>
                                @if(isset($layoutArr['viewDataObj']->ifsc_code) && $layoutArr['viewDataObj']->ifsc_code != '')
                                    <input type="text" name="TOrganizations[ifsc_code]" class="form-control" id="ifsc_code"  autocomplete="off" value="{{$layoutArr['viewDataObj']->ifsc_code}}">
                                @else
                                    <input type="text" name="TOrganizations[ifsc_code]" class="form-control" id="ifsc_code"  autocomplete="off">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Account Number</label>
                                @if(isset($layoutArr['viewDataObj']->account_number) && $layoutArr['viewDataObj']->account_number != '')
                                    <input type="text" name="TOrganizations[account_number]" class="form-control" id="account_number"  autocomplete="off" onkeypress="javascript : return isNumberKey(event);" value="{{$layoutArr['viewDataObj']->account_number}}">
                                @else
                                    <input type="text" name="TOrganizations[account_number]" class="form-control" id="account_number"  autocomplete="off">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <center><h4><b>Packages Details</b></h4></center>
                        <div class="col-md-12">
                            <div class="form-group margine10bot">
                                <div class="col-md-12">
                                @foreach($layoutArr['packagesArr'] as $key=>$val)
                                <div class="col-md-3" style="padding-bottom: 5px;">
                                @if(is_array($layoutArr['viewDataObj1']) && in_array($key,$layoutArr['viewDataObj1']))
                                <input type="checkbox" class="form-group" id="t_features_id" name="t_features_id[]" autocomplete="off" value="{{$key}}" checked>  {{$val}}
                                @else
                                <input type="checkbox" class="form-group" id="t_features_id" name="t_features_id[]" autocomplete="off" value="{{$key}}"/>  {{$val}}
                                @endif
                                </div>
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <center>
                        <div class="box-footer">
                            <button type="button" onclick="dataValidate();" class="btn btn-success">Save</button>
                            <button class="btn btn-warning" onclick="cancelFrm();" type="button">Cancel</button>
                        </div>
                    </center>
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
    function dataValidate(){
        $('.imgLoader').show();
        $('.error-message').remove();
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': csrfTkn
            }
        });
        $.ajax({
            url:baseUrl+'/master/validateOrganizationDetails',
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
                       showJsonErrors(resp[2]);
                    }else if(resp[1] == 'SUCCESS'){
                        $('#sucMsgDiv').removeClass('text-none');
                        $('.sucmsgdiv').html(resp[2]);
                        $('#sucMsgDiv').show('slow');
                        document.forms['entryFrm'].submit();
                        //setTimeout(function(){window.parent.location.reload(true);}, 1000);
                    }
                }
            },
            error: function(xhr, textStatus, thrownError) {
                alert('Something went to wrong.Please Try again later...');
            }
        });
    }
</script>
@stop