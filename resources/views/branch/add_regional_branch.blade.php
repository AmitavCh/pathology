@extends('layouts.admin-master')
@section('home-title')
Master | Regional Branch
@endsection
@section('admin-content')
@php
use App\Http\Controllers\Controller;
@endphp
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
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Default box -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Regional Branch Details Listing</h3>
                    <div class="box-tools pull-right">
                        <a href="{{ URL::to('branch/add_regional_branch_data/')}}" class="iframeLarge" ><button type="button" class="btn btn-warning"><i class="fa fa-plus"></i> Add Regional Branch Details</button></a>
                    </div>
                </div>
                <div class="box-body">
                    
                    <div id="listingTable">
                        @if(is_object($layoutArr['custompaginatorres']) && count($layoutArr['custompaginatorres']) > 0)	
                        <div class="table-responsive">            
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>#</th>
                                    <th>Branch Name</th>
                                    <th>Branch Code</th>
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
                                    <td>{{ $resVal->branch_name }}</td>
                                    <td>{{ $resVal->branch_code }}</td>
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
                                       						
                                        <a class="btn-sm iframeLarge" href="{{ URL::to('branch/add_regional_branch_data/'.base64_encode(base64_encode($resVal->id))) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @if($resVal->status == 'N')
                                        <a class="btn-sm" title="Active Record" onclick="regionalBranchActive({{ $resVal->id }})">
                                            <i class="fa fa-check-circle-o"></i>
                                        </a> 
                                        @endif
                                        @if($resVal->status == 'Y')
                                        <a class="btn-sm" title="Deactive Record" onclick="regionalBranchDeactive({{ $resVal->id }})">
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
@stop