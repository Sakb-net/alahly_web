<header class="main-header">
    <!-- Logo -->
    <a href="{{ route('home') }}" class="logo" target="_blank">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">ALAHLIFC</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">ALAHLIFC</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!--<i class="fa fa-envelope-o"></i>-->
                <!-- Notifications: style can be found in dropdown.less -->
<!--                @if($post_all == 1)
                <li class="dropdown notifications-menu">
                    <a href="{{ route('admin.orders.index') }}">
                        <i class="fa fa-gift"></i>
                        <span class="label label-danger">@if($post_count > 0) {{ $post_count }} @endif</span>
                    </a>
                </li>
                @endif-->
<!--                @if($comment_all == 1)
                <li class="dropdown notifications-menu">
                    <a href="{{ route('admin.comments.index') }}">
                        <i class="fa fa-comment"></i>
                        <span class="label label-danger">@if($comment_count > 0) {{ $comment_count }} @endif</span>
                    </a>
                </li>
                @endif-->
                @if($contact_all == 1)
<!--                  <li class="dropdown notifications-menu">
                    <a href="">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-danger"></span>
                    </a>
                </li>-->
                
<!--                <li class="dropdown messages-menu">
                    <a href="{{ route('admin.contacts.type','visitor') }}">
                        <i class="fa fa-comment"></i>
                        <span class="label label-danger"> visitor_count</span>
                    </a>
                </li>-->
                <li class="dropdown messages-menu">
                    <a href="{{ route('admin.contacts.type','contact') }}">
                        <i class="fa fa-envelope-open"></i>
                        <span class="label label-danger">@if($contact_count > 0) {{ $contact_count }} @endif</span>
                    </a>
                </li>
                @endif
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if($user_account->image != NULL)
                        <img src="{{ $user_account->image }}" class="user-image" alt="User Image">

                        @else
                        <img src="{{ asset('css/img/user2-160x160.jpg') }}" class="user-image" alt="User Image">
                        @endif

                        <span class="hidden-xs">{{ $user_account->display_name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            @if($user_account->image != NULL)
                            <img src="{{ $user_account->image }}" class="img-circle" alt="User Image">

                            @else
                            <img src="{{ asset('css/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                            @endif

                            <p>
                                {{ $user_account->display_name }}

                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="pull-right">
                              <a href="{{ route('admin.users.edit',$user_account->id) }}" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-left">
                                <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat"
                                   onclick="event.preventDefault();
                                           document.getElementById('logout-form').submit();">
                                    Sign out
                                </a>
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
