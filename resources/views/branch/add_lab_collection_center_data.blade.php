@extends('layouts.iframelightbox')
@section('home-title')
Master | Menu Management
@endsection
@section('admin-content')
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
                <script>setTimeout(function(){window.parent.location.reload(true);}, 3000); </script>
            </div>
            @endif
        </div>			
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-body">
                    <form action="{{ url('branch/saveLabCollectionCenter') }}" method="post" role="form" id="entryFrm" enctype="multipart/form-data">
                    <input type="hidden" name="TBusinessLogisticDtls[id]" class="form-control" id="id" >
                    <input type="hidden" name="TBusinessLogisticDtls[t_branch_details_id]" class="form-control" id="t_branch_details_id" >
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Lab / Collection Center Name</label>
                                <input type="text" name="TBusinessLogisticDtls[business_logistic_name]" class="form-control" id="business_logistic_name" autocomplete="off" onkeypress="javascript : return validateAlpha(event);">
                             </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Email Address</label>
                                <input type="text" name="TBusinessLogisticDtls[email_id]" class="form-control" id="email_id" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Contact Number</label>
                                <input type="text" name="TBusinessLogisticDtls[mobile_number]" class="form-control" id="mobile_number"  autocomplete="off" onkeypress="javascript : return isNumberKey(event);">
                            </div>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name">Other Contact Number</label>
                                <input type="text" name="TBusinessLogisticDtls[other_mobile_number]" class="form-control" id="other_mobile_number"  autocomplete="off" onkeypress="javascript : return isNumberKey(event);">
                            </div>
                        </div>
                        <div class="col-md-4">
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
                        <div class="col-md-4">
                            <div class="form-group margine10bot">
                                <label for="inquiry_name"><span class="formError">*</span>Address</label>
                                @if(isset($layoutArr['viewDataObjs']->address) && $layoutArr['viewDataObjs']->address != '')
                                    <textarea type="text" name="TBusinessLogisticDtls[address]" class="form-control" rows="3" id="address" autocomplete="off">{{$layoutArr['viewDataObjs']->address}}</textarea>
                                @else
                                    <textarea type="text" name="TBusinessLogisticDtls[address]" class="form-control" rows="3" id="address" autocomplete="off"></textarea>
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
@endsection