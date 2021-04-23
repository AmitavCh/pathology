@extends('layouts.admin-master')
@section('home-title')
Master | Organization
@endsection
@section('admin-content')
@php
use App\Http\Controllers\Controller;
@endphp
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
                    <h3 class="box-title">Organization Details Listing</h3>
                    <div class="box-tools pull-right">
                        <a href="{{ URL::to('master/add_organization_data/')}}" class="iframeLarge" ><button type="button" class="btn btn-warning"><i class="fa fa-plus"></i> Add Organization Details</button></a>
                    </div>
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
                                    <th>Mobile No. / WhatsApp</th>
                                    <th>Contacts(LIMIT)</th>
                                    <th>Branches(LIMIT)</th>
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
                                    <td>{{ $resVal->points_of_contact }}</td>
                                    <td>{{ $resVal->number_of_branch }}</td>
                                    <?php if($resVal->logo != ''){ ?>
                                    <td><img src="{{asset('public/files/orig/'.$resVal->logo)}}" height="100"></td>
                                    <?php }else{ ?>
                                    <td><img src="{{asset('public/no.png')}}" height="100"></td>
                                    <?php } ?>
                                    <td><pre>{{$resVal->address}}</pre></td>
                                    <td>{{$resVal->status}}</td>
                                    <td class="text-center">							
                                       						
                                        <a class="iframeLarge btn-sm" title="Edit Record" href="{{ URL::to('master/add_organization_data/'.base64_encode(base64_encode($resVal->id))) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @if($resVal->status == 'N')
                                        <a class="btn-sm" title="Active Record" onclick="organizationDetailsActive({{ $resVal->id }})">
                                            <i class="fa fa-check-circle-o"></i>
                                        </a> 
                                        @endif
                                        @if($resVal->status == 'Y')
                                        <a class="btn-sm" title="Deactive Record" onclick="organizationDetailsDeactive({{ $resVal->id }})">
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
@stop