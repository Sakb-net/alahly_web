<!-- Start Navigation -->
<nav class="navbar navbar-default bootsnav mymenu-wrapper">
    <!-- Start Top Search -->
    <div class="top-search">
        <div class="container">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-search"></i></span>
                <input type="text" class="form-control" placeholder="بحث">
                <span class="input-group-addon close-search"><i class="fa fa-times"></i></span>
            </div>
        </div>
    </div>
    <!-- End Top Search -->
    <div class="container">
        <!-- Start Atribute Navigation -->
        <div class="attr-nav">
            <ul>
                <li class="dropdown">
                    <a class="dropdown-toggle @if(isset($activ_menu)&&$activ_menu==14) activ_cart @endif" data-toggle="dropdown" >
                        <i class="fa fa-shopping-bag"></i>
                        <span class="badge count_product_cart">@if($count_product_cart>0){{$count_product_cart}}@endif</span>
                    </a>
                    <ul class="dropdown-menu cart-list draw_cartProducts" id="draw_cartProducts">
                        @include('site.layouts.menu_cart')
                    </ul>
                </li>
                <!--<li class="search"><a href="#"><i class="fa fa-search"></i></a></li> -->

            </ul>
        </div>
        <!-- End Atribute Navigation -->
        <!-- Start Header Navigation -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}" draggable="false">
                <img src="{{ asset('images/logo/logo.png')}}" class="logo" alt="{{ $title }}" draggable="false">
            </a>
        </div>
        <!-- End Header Navigation -->
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="nav navbar-nav navbar-right" data-in="fadeInDown" data-out="fadeOutUp">
                @include('site.layouts.menu')
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
</nav>