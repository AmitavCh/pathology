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
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Sub Menu Listing</h3>
                    <div class="box-tools pull-right">
                        <a href="{{ URL::to('master/add_sub_menu_data/')}}" class="iframeSml" ><button type="button" class="btn btn-warning"><i class="fa fa-plus"></i> Add Sub Menu</button></a>
                    </div>
                </div>
                <div class="box-body">
                    <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap">
                        <form  action="" method="get">
                            <div class="row">
                                <div class="col-md-3 margine10bot"> 
                                    <div class="form-group">
                                        <select class="form-control" id="search_menu_id" name="search_menu_id">
                                            @foreach($layoutArr['menuArr'] as $menu)
                                                <option value="{{$menu['id']}}">{{$menu['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 margine10bot"> 
                                    <div class="form-group">
                                        <input type="text" name="search_sub_menu_name" maxlength="25" class="form-control" id="search_sub_menu_name" placeholder="Search by sub menu name" autocomplete="off"/>
                                    </div>
                                </div>
                                <div class="col-md-1 margine10bot">
                                    <div class="form-group">
                                        <span class="form-group-btn">
                                            <button type="submit" class="btn btn-md btn-info"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
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
                                    <th>Menu Name</th>
                                    <th>Sub Menu Name</th>
                                    <th>Sub Menu Url</th>
                                    <th>Sub Menu Order</th>
                                    <th>Sub Menu Icon</th>
                                    <th class="text-center">Action</th>
                                </tr>
                                <?php $trCnt = ($layoutArr['custompaginatorres']->perPage() * ($layoutArr['custompaginatorres']->currentPage() -1))+1;?>               
                                @foreach($layoutArr['custompaginatorres'] as $resKey=>$resVal)
                                <tr>
                                    <td>{{ $trCnt }}</td>
                                    <td>{{ Controller::getDisplayFieldName($resVal->menu_id,'menus',['menu_name']) }}</td>
                                    <td>{{$resVal->sub_menu_name}}</td>
                                    <td>{{$resVal->sub_menu_url}}</td>
                                    <td>{{$resVal->sub_menu_order}}</td>
                                    <td>{{$resVal->sub_menu_icon}}</td>
                                    <td class="text-center">							
                                        <a class="iframeSml btn-sm" href="{{ URL::to('master/add_sub_menu_data/'.base64_encode(base64_encode($resVal->id))) }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        @if($resVal->is_active == "N")
                                        <a class="btn-sm" title="Active Record" onclick="ActiveSubMenu({{ $resVal->id }})">
                                            <i class="fa fa-check-circle-o"></i>
                                        </a> 
                                        @endif
                                        @if($resVal->is_active == "Y")
                                        <a class="btn-sm" title="Deactive Record" onclick="DeActiveSubMenu({{ $resVal->id }})">
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