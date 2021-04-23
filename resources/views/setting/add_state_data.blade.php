@extends('layouts.iframelightbox')
@section('home-title')
Setting | Add City
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
            <div class="box box-info">
                <div class="box-body">
                    <form method="post" id="entryFrm" name="entryFrm">
                        {{ csrf_field() }}
                        <input type="hidden" name="id" class="form-control" id="id" >
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group margine10bot">
                                    <label for="course_name"><span class="formError">*</span>State Name :</label>
                                    <input type="text" name="TState[state_name]" maxlength="100" class="form-control" id="state_name" autocomplete="off" onkeypress="javascript : return validateAlpha(event);"/>
                                </div>
                            </div>
                        </div>						
                        <div class="box-footer">
                            <button type="button" onclick="saveState();" class="btn btn-success">Save</button>
                            <button class="btn btn-warning" onclick="cancelFrm();" type="button">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>			
    </div>
</section>
@endsection