@extends('layouts.admin-master')
@section('home-title')
Master | Create Master User
@endsection
@section('admin-content')
@php
use App\Http\Controllers\Controller;
@endphp

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
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Master User Listing</h3>
                    <div class="box-tools pull-right">
                        <a href="{{ URL::to('master/add_master_user_data/')}}" class="iframeLarge" ><button type="button" class="btn btn-warning"><i class="fa fa-plus"></i> Add Master Admin</button></a>
                    </div>
                </div>
                <div class="box-body">

                    <div id="listingTable">
                        @if(is_object($layoutArr['custompaginatorres']) && count($layoutArr['custompaginatorres']) > 0)
                        <div class="table-responsive printDiv">            
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>#</th>
                                    <th>Organization</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <?php $trCnt = ($layoutArr['custompaginatorres']->perPage() * ($layoutArr['custompaginatorres']->currentPage() - 1)) + 1; ?>                
                                @foreach($layoutArr['custompaginatorres'] as $resKey=>$resVal)
                                <?php 
                                if($resVal->status == 1){
                                    $status = "N";
                                }else if($resVal->status == 0){
                                    $status = "Y";
                                }
                              ?>
                                <tr>
                                    <td>{{ $trCnt }}</td>
                                    <td>{{Controller::getDisplayFieldName($resVal->t_organizations_id,'t_organizations',['organization_name'])}}</td>
                                    <td>{{$resVal->full_name}}</td>
                                    <td>{{$resVal->email_id}}</td>
                                    <td>{{ Controller::getDisplayFieldName($resVal->role_id,'roles',['role_name']) }}</td>
                                    <td>{{$resVal->mobile_number}}</td>
                                    <td>{{$status}}</td>
                                    <td class="text-center">							
                                        <a class="iframeLarge btn-sm" href="{{ URL::to('/master/add_master_user_data/'.base64_encode(base64_encode($resVal->id))) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @if($resVal->status == 1)
                                        <a class="btn-sm" title="Active Record" onclick="ActiveUser({{ $resVal->id }})">
                                            <i class="fa fa-check-circle-o"></i>
                                        </a> 
                                        @endif
                                        @if($resVal->status == 0)
                                        <a class="btn-sm" title="Deactive Record" onclick="DeActiveUser({{ $resVal->id }})">
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
                        {{ $layoutArr['custompaginatorres']->appends($layoutArr['sortFilterArr'])->links('') }}
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
@stop