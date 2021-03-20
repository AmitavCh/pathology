@extends('layouts.admin-master')
@section('home-title')
Master | Create City
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
                    <h3 class="box-title">Add City</h3>
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
                                    <label for="course_name"><span class="formError">*</span> State Name</label>
                                    <select class="form-control" id="t_states_id" name="TCities[t_states_id]">
                                        @foreach($layoutArr['stateArr'] as $menu)
                                            <option value="{{$menu['id']}}">{{$menu['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group margine10bot">
                                    <label for="course_name"><span class="formError">*</span>City Name :</label>
                                    <input type="text" name="TCities[city_name]" maxlength="100" class="form-control" id="city_name" autocomplete="off" onkeypress="javascript : return validateAlpha(event);"/>
                                </div>
                            </div>
                        </div>						
                        <div class="box-footer">
                            <button type="button" onclick="saveCity();" class="btn btn-success">Save</button>
                            <button class="btn btn-warning" onclick="cancelFrm();" type="button">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>			
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">					
                <div class="box-header">
                    <h3 class="box-title">City Listing</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>							
                    </div>
                </div>
                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap">
                        <form  action="" method="get">
                            <div class="row">
                                <div class="col-md-3 margine10bot"> 
                                    <label for="role_name_listing">City Name</label>
                                    <input type="text" name="search_city_name" maxlength="100" class="form-control" id="search_city_name" placeholder="Search by city name" autocomplete="off"/>
                                </div>
                                <div class="col-md-3 margine25top margine10bot">
                                    <button type="submit" class="btn btn-info"><i class="icon-search"></i>Search</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="listingTable">
                        @if(is_object($layoutArr['custompaginatorres']) && count($layoutArr['custompaginatorres']) > 0)	
                        <div class="table-responsive">            
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>#</th>
                                    <th>State Name</th>
                                    <th>City Name</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <?php $trCnt = ($layoutArr['custompaginatorres']->perPage() * ($layoutArr['custompaginatorres']->currentPage() - 1)) + 1; ?>              
                                @foreach($layoutArr['custompaginatorres'] as $resKey=>$resVal)
                                <tr>
                                    <td>{{ $trCnt }}</td>
                                    <td>{{ Controller::getDisplayFieldName($resVal->t_states_id,'t_states',['state_name']) }}</td>
                                    <td>{{$resVal->city_name}}</td>
                                    <td class="text-center">							
                                        <a class="btn btn-primary btn-sm" href="{{ URL::to('setting/add_city/'.base64_encode(base64_encode($resVal->id))) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @if($resVal->status == "N")
                                        <a class="btn btn-success btn-sm" title="Active Record" onclick="cityActive({{ $resVal->id }})">
                                            <i class="fa fa-check-circle-o"></i>
                                        </a> 
                                        @endif
                                        @if($resVal->status == "Y")
                                        <a class="btn btn-warning btn-sm" title="Deactive Record" onclick="cityDeactive({{ $resVal->id }})">
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
@endsection