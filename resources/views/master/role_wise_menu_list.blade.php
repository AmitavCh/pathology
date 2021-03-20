@extends('layouts.ajax')
@section('admin-content')  

<?php

use App\Http\Controllers\Controller;
?>
@if(is_array($layoutArr['menuSubMenuArr']) && count($layoutArr['menuSubMenuArr']) > 0)
<ul class="nav nav-pills nav-stacked">
    @foreach($layoutArr['menuSubMenuArr'] as $menuKey=>$menuVal)
    @if(is_object($menuVal) && $menuVal->count() > 0)
    <li>                                                                
        <span>{{ Controller::getDisplayFieldName($menuKey,'menus',['menu_name']) }}</span>                                                                                            
        <ul class="submenu">
            @foreach($menuVal as $subMenuKey=>$subMenuVal)
            <li style="list-style: none;">
                @if(in_array($subMenuVal->id,$layoutArr['editSubMenuList']))
                <input type="checkbox" name="subMenuIdArr[]" value="{{$subMenuVal->id}}" class="flat"/>
                @else
                <input type="checkbox" name="subMenuIdArr[]" value="{{$subMenuVal->id}}" class="flat" />
                @endif                                                                                      
                {{ $subMenuVal->sub_menu_name }}                                          
            </li>
            @endforeach
        </ul>
    </li>
    @else
    <li>
        @if(in_array($menuKey,$layoutArr['editMenuList']))
        <input type="checkbox" name="menuIdArr[]" value="{{$menuKey }}" class="flat"/>
        @else
        <input type="checkbox" name="menuIdArr[]" value="{{$menuKey }}" class="flat" />
        @endif                                                                  
        <span>{{ Controller::getDisplayFieldName($menuKey,'menus',['menu_name']) }}</span>                                
    </li>
    @endif
    @endforeach
</ul>
@endif    
@stop