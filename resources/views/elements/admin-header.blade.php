@php
use App\Http\Controllers\Controller;
@endphp
<header class="main-header">
    <a href="{{ URL::to('/censor/dashboard') }}" class="logo">
        <span class="logo-mini"><b>Project Name</b></span>
        <span class="logo-lg">Project Name</span>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if(isset(Auth::user()->user_photo) && Auth::user()->user_photo != '')
                        <img src="{{asset('public/files/orig/'.Auth::user()->user_photo)}}" alt="Photo" class="user-image">
                        @else
                        <img src="{{asset('public/img/no_image_autocpl.jpg')}}" alt="Photo" class="user-image">
                        @endif
                        <span class="hidden-xs">
                            @if(isset(Auth::user()->full_name) && Auth::user()->full_name != '')
                            {{ Auth::user()->full_name }}
                            @endif
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            @if(isset(Auth::user()->user_photo) && Auth::user()->user_photo != '')
                            <img src="{{asset('public/files/orig/'.Auth::user()->user_photo)}}" alt="Photo" class="img-circle">
                            @else
                            <img src="{{asset('public/img/no_image.jpg')}}" alt="Photo" class="img-circle">
                            @endif
                            <p>
                                @if(isset(Auth::user()->full_name))
                                Welcome {{ Auth::user()->full_name }}
                                <small>{{Controller::getRoleName(Auth::user()->role_id)}}</small>
                                @endif
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{{ URL::to('user/profile') }}" class="btn btn-success btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                                <a href="{{ URL::to('user/logout') }}" class="btn btn-success btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>