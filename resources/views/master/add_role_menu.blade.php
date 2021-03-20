@extends('layouts.admin-master')
@section('home-title')
Master | Sub Menu
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
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Manage Role Assign</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>							
                    </div>
                </div>
                <div class="box-body">
                    <form method="post" id="entryFrm" name="entryFrm">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" class="form-control" id="id" >
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group margine10bot">
                                    <label for="course_name"><span class="formError">*</span> Role Name</label>
                                    <select class="form-control" id="role_id" name="RoleMenu[role_id]" autocomplete="off" onchange="getMenuSubmenu(this.value)">
                                        @foreach($layoutArr['roleArr'] as $menu)
                                            <option value="{{$menu['id']}}">{{$menu['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>	
                        <div id="listingTable"></div>
                        <div class="box-footer">
                            <button type="button" onclick="saveRoleMenuFrm();" class="btn btn-success">Save</button>
                            <button class="btn btn-warning" onclick="cancelFrm();" type="button">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>			
    </div>
</section>
@endsection