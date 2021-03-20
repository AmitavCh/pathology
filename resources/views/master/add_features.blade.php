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
                    <h3 class="box-title">Create Features</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <form method="post" role="form" id="entryFrm" enctype="multipart/form-data">
                        <input type="hidden" name="User[id]" class="form-control" id="id" >
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group margine10bot">
                                    <label for="inquiry_name"><span class="formError">*</span>Features Name:</label>
                                    <input type="text" name="User[full_name]" class="form-control" id="full_name" autocomplete="off">
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
                            <button type="button" onclick="userValidate();" class="btn btn-success">Save</button>
                            <button class="btn btn-warning" onclick="cancelFrm();" type="button">Cancel</button>
                        </div>
                        </from>
                </div>
            </div>
        </div>
    </div>
</section>
@stop