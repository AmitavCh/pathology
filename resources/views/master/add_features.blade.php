@extends('layouts.admin-master')
@section('home-title')
Master | Add Features
@endsection
@section('admin-content')
@php
use App\Http\Controllers\Controller;
@endphp
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success alert-dismissable" id="sucMsgDiv" style="display: none;">
                <i class="fa fa-check"></i>
                <b>Success!</b>
                <span class="sucmsgdiv"></span>					
            </div>
            <div class="alert alert-danger alert-dismissable" id="failMsgDiv" style="display: none;">
                <i class="fa fa-ban"></i>					
                <b>Info!</b>
                <span class="failmsgdiv"></span>
            </div>
        </div>			
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- Default box -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Create Features</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <form method="post" role="form" id="entryFrm" enctype="multipart/form-data">
                        <input type="hidden" name="TFeatures[id]" class="form-control" id="id" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group margine10bot">
                                    <label for="inquiry_name"><span class="formError">*</span>Features Name:</label>
                                    <input type="text" name="TFeatures[feature_name]" class="form-control" id="feature_name" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-1" style="margin-top: 25px;">
                                <div class="form-group margine10bot">
                                    <button type="button" class="btn btn-info" onclick="getMenuSubmenuList()"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div id="listingTable"></div>
                        <div class="box-footer">
                            <button type="button" onclick="saveFeaturesData();" class="btn btn-success">Save</button>
                            <button class="btn btn-warning" onclick="cancelFrm();" type="button">Cancel</button>
                        </div>
                        </from>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-info">

                <div class="box-header with-border">
                    <h3 class="box-title">Features List</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div id="listingTable">
                        @if(is_object($layoutArr['custompaginatorres']) && count($layoutArr['custompaginatorres']) > 0)	
                        <div class="table-responsive">            
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <?php $trCnt = 1; ?>                
                                @foreach($layoutArr['custompaginatorres'] as $resKey=>$resVal)
                                <tr>
                                    <td>{{ $trCnt }}</td>
                                    <td>{{ $resVal->feature_name }}</td>
                                    <td class="text-center">							
                                        <a class="btn-sm" href="{{ URL::to('master/add_features/'.base64_encode(base64_encode($resVal->id))) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
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