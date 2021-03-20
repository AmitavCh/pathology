@extends('layouts.iframelightbox')
@section('home-title')
Master | Sub Menu Management
@endsection
@section('admin-content')
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
            <div class="box box">
                <div class="box-body">
                    <form method="post" id="entryFrm" name="entryFrm">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" class="form-control" id="id" >
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group margine10bot">
                                    <label for="course_name"><span class="formError">*</span> Menu Name</label>
                                    <select class="form-control" id="menu_id" name="SubMenu[menu_id]">
                                        @foreach($layoutArr['menuArr'] as $menu)
                                            <option value="{{$menu['id']}}">{{$menu['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group margine10bot">
                                    <label for="course_name"><span class="formError">*</span>Sub Menu Name</label>
                                    <input type="text" name="SubMenu[sub_menu_name]" maxlength="55" class="form-control" id="sub_menu_name" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group margine10bot">
                                    <label for="course_name"><span class="formError">*</span>Sub Menu Order</label>
                                    <input type="text" name="SubMenu[sub_menu_order]" maxlength="55" class="form-control" id="sub_menu_order" onkeypress="javascript: return isNumberKey(this)"autocomplete="off"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group margine10bot">
                                    <label for="course_name"><span class="formError">*</span>Sub Menu Url</label>
                                    <input type="text" name="SubMenu[sub_menu_url]" maxlength="55" class="form-control" id="sub_menu_url" autocomplete="off"/>
                                </div>
                            </div>
							<div class="col-md-2">
                                <div class="form-group margine10bot">
                                    <label for="course_name">Method :</label>
                                    <input type="text" name="SubMenu[action]" maxlength="55" class="form-control" id="action" autocomplete="off"/>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group margine10bot">
                                    <label for="course_name">Sub Menu Icon :</label>
                                    <input type="text" name="SubMenu[sub_menu_icon]" maxlength="55" class="form-control" id="sub_menu_icon" autocomplete="off"/>
                                </div>
                            </div>
                        </div>						
                        <div class="box-footer">
                            <button type="button" onclick="saveSubMenuFrm();" class="btn btn-success">Save</button>
                            <button class="btn btn-warning" onclick="cancelFrm();" type="button">Cancel</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>			
    </div>
</section>
@endsection