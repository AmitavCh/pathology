<?php

use App\Http\Controllers\Controller;

$curRoute = Route::currentRouteAction();
$controller = '';
$action = '';
if ($curRoute != '') {
    if (strpos($curRoute, '@')) {
        $routePartArr = explode('@', $curRoute);
        if (isset($routePartArr) && is_array($routePartArr) && count($routePartArr) > 0) {
            if (isset($routePartArr[0])) {
                $controllerName = $routePartArr[0];
                $controllerNameArr = explode("/", str_replace('\\', '/', $controllerName));
                //print_r($controllerNameArr);
                $controller = $controllerNameArr[3];
            }
            if (isset($routePartArr[1])) {
                $action = $routePartArr[1];
            }
        }
    }
}
$menuSubMenuArr = Controller::getMenuSubmenu();
$roleMenuArrArr = Controller::getRoleMenuAdminLeftPane();
//echo'<pre>';print_r($menuSubMenuArr);echo'</pre>';
?>
<aside class="main-sidebar">
    <section class="sidebar">
        @if(is_array($menuSubMenuArr) && count($menuSubMenuArr) > 0)			
        <ul class="sidebar-menu">
            @foreach($menuSubMenuArr as $menuKey=>$menuVal)					
                @if(is_array($menuVal['submenus']) && count($menuVal['submenus']) > 0)							
                    @if(isset($roleMenuArrArr['editMenuList']) && is_array($roleMenuArrArr['editMenuList']) && in_array($menuVal['id'],$roleMenuArrArr['editMenuList']))								
                    <li class="treeview @if($menuVal['controller'] == $controller) active @endif">
                        <a href="javascript:void(0);" class="dropdown-toggle">	
                            <i class="{{  $menuVal['menu_icon'] }}"></i>
                            <span>{{  $menuVal['menu_name'] }}</span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>								
                        <ul class="treeview-menu">
                            @foreach($menuVal['submenus'] as $subMenuKey=>$subMenuVal)
                                @if(isset($roleMenuArrArr['editSubMenuList']) && is_array($roleMenuArrArr['editSubMenuList']) && in_array($subMenuVal['id'],$roleMenuArrArr['editSubMenuList']))
                                <li class="@if($subMenuVal['action'] == $action) active @endif">
                                    <a href="{{URL::to($subMenuVal['sub_menu_url'])}}">												
                                        <i class="{{$subMenuVal['sub_menu_icon']}}"></i>
                                        {{$subMenuVal['sub_menu_name']}}
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    @endif
                @else						
                    @if(isset($roleMenuArrArr['editMenuList']) && is_array($roleMenuArrArr['editMenuList']) && in_array($menuVal['id'],$roleMenuArrArr['editMenuList']))								
                    <li class="treeview @if($menuVal['controller'] == $controller) active @endif">
                        <a href="{{URL::to($menuVal['menu_url'])}}">
                            <i class="{{ $menuVal['menu_icon'] }}"></i>
                            <span>{{  $menuVal['menu_name'] }}</span>
                        </a>
                    </li>
                    @endif
                @endif
            @endforeach					
        </ul>
        @endif
    </section>
</aside>


