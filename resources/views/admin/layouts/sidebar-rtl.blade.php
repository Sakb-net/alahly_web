
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-right image">
                @if($user_account->image != NULL)
                <img src="{{ $user_account->image }}" class="img-circle" alt="User Image">
                @else
                <img src="{{ asset('css/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
                @endif
            </div>
            <div class="pull-right info">
                <p>{{ $user_account->display_name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu">
            @if($category_all == 1)
            <!--            <li class="treeview">
                            <a href="">
                                <i class="fa fa-home"></i> <span>الرئيسية</span> 
                                <i class="fa fa-angle-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('admin.pages.home') }}">
                                        <i class="fa fa-image"></i> <span>الصورة الخلفية</span> 
                                    </a></li>
                                <li><a href="{{ route('admin.posts.type','banner') }}">
                                        <i class="fa fa-home"></i> <span>بنر الاعلان</span> 
                                    </a></li>
                            </ul>
                        </li>-->
            <li class="treeview">
                <a href="">
                    <i class="fa fa-sitemap"></i> <span>السكشن</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.categories.create') }}">
                            <i class="fa fa-plus-square"></i> <span>اضافة سكشن </span> 
                        </a></li>
                    <li><a href="{{ route('admin.categories.index') }}">
                            <i class="fa fa-cubes"></i> <span> كل السكشن </span> 
                        </a></li>
                    <!--                    <li><a href="{{ route('admin.subcategories.create') }}">
                                                <i class="fa fa-plus-square"></i> <span>اضافة سكشن فرعى</span> 
                                            </a></li>
                                        <li><a href="{{ route('admin.subcategories.index') }}">
                                                <i class="fa fa-cube"></i> <span> السكشن الفرعية</span> 
                                            </a></li>-->
                    <li><a href="{{ route('admin.allcategories.search') }}">
                            <i class="fa fa-search"></i> <span>بحث السكشن</span> 
                        </a></li>
                </ul>
            </li>
            <!--end categories-->
            @endif
            @if($post_all == 1)  
            <li class="treeview">
                <a href="">
                    <i class="fa fa-rocket"></i> <span> {{$chair_title}}</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <!--                    <li><a href="{{ route('admin.posts.createallpost','chair') }}">
                                                <i class="fa fa-plus-square"></i> <span>اضافة مجموعة جديد</span> 
                                            </a></li>-->
                    <li><a href="{{ route('admin.posts.creat','chair') }}">
                            <i class="fa fa-plus-square"></i> <span>اضافة جديدة</span> 
                        </a></li>
                    <li><a href="{{ route('admin.posts.type','chair') }}">
                            <i class="fa fa-rocket"></i> <span>{{$chair_title}} </span> 
                        </a></li>
                    <li><a href="{{ route('admin.posts.search','chair') }}">
                            <i class="fa fa-search"></i> <span>بحث {{$chair_title}}</span> 
                        </a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="">
                    <i class="fa fa-gift"></i> <span>شراء التذاكر</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <!--                    <li><a href="{{ route('admin.posts.creat','chair') }}">
                                                <i class="fa fa-plus-square"></i> <span>اضافة جديدة</span> 
                                            </a></li>-->
                    <li><a href="{{ route('admin.orders.index') }}">
                            <i class="fa fa-gift"></i> <span>شراء التذاكر </span> 
                        </a></li>
                    <li><a href="{{ route('admin.orders.search') }}">
                            <i class="fa fa-search"></i> <span>بحث شراء التذاكر </span> 
                        </a></li>
                </ul>
            </li>
            <!--all albums-->
            <li class="treeview">
                <a href="">
                    <i class="fa fa-file-image-o"></i> <span>{{$album_title}}</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.albums.create') }}">
                            <i class="fa fa-plus-square"></i> <span>اضافة الالبوم</span> 
                        </a></li>
                    <li><a href="{{ route('admin.albums.index') }}">
                            <i class="fa fa-file-image-o"></i> <span>  {{$album_title}}</span> 
                        </a></li>
                    <li><a href="{{ route('admin.subalbums.index') }}">
                            <i class="fa fa-image"></i> <span>كل الصور</span> 
                        </a></li>
                </ul>
            </li>
            <!--end albums-->
            <li class="treeview">
                <a href="">
                    <i class="fa fa-file-video-o"></i> <span>الفديوهات</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.videos.create') }}">
                            <i class="fa fa-plus-square"></i> <span>اضافة فديو</span> 
                        </a></li>
                    <li><a href="{{ route('admin.videos.index') }}">
                            <i class="fa fa-file-video-o"></i> <span>  الفديوهات</span> 
                        </a></li>
                    <li><a href="{{ route('admin.videos.search') }}">
                            <i class="fa fa-search"></i> <span>بحث الفديوهات</span> 
                        </a></li>
                    <li><a href="{{ route('admin.videocomments.index') }}">
                            <i class="fa fa-comment"></i> <span> تعليقات الفديوهات</span> 
                        </a></li>
                    <li><a href="{{ route('admin.videocomments.search') }}">
                            <i class="fa fa-search"></i> <span>بحث تعليقات الفديوهات</span> 
                        </a></li>     
                </ul>
            </li>
            <li class="treeview">
                <a href="">
                    <i class="fa fa-newspaper-o"></i> <span>{{trans('app.news')}}</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.blogs.create') }}">
                            <i class="fa fa-plus-square"></i> <span>{{trans('app.add_news')}}</span> 
                        </a></li>
                    <li><a href="{{ route('admin.blogs.index') }}">
                            <i class="fa fa-newspaper-o"></i> <span> {{trans('app.news')}}</span> 
                        </a></li>
                    <li><a href="{{ route('admin.blogs.search') }}">
                            <i class="fa fa-search"></i> <span>{{trans('app.search_news')}}</span> 
                        </a></li>
                    <li><a href="{{ route('admin.blogcomments.index') }}">
                            <i class="fa fa-comment"></i> <span> تعليقات الاخبار</span> 
                        </a></li>
                    <li><a href="{{ route('admin.blogcomments.search') }}">
                            <i class="fa fa-search"></i> <span>بحث تعليقات الاخبار</span> 
                        </a></li>     
                </ul>
            </li>
            <li class="treeview">
                <a href="">
                    <i class="fa fa-cubes"></i> <span>الفريق</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.clubteams.create') }}">
                            <i class="fa fa-plus-square"></i> <span>اضافة الفريق </span> 
                        </a></li>
                    <li><a href="{{ route('admin.clubteams.index') }}">
                            <i class="fa fa-cubes"></i> <span> كل الفريق </span> 
                        </a></li>
                    <!--                    <li><a href="{{ route('admin.subcategories.create') }}">
                                                <i class="fa fa-plus-square"></i> <span>اضافة سكشن فرعى</span> 
                                            </a></li>
                                        <li><a href="{{ route('admin.subcategories.index') }}">
                                                <i class="fa fa-cube"></i> <span> السكشن الفرعية</span> 
                                            </a></li>-->
                    <li><a href="{{ route('admin.allclubteams.search') }}">
                            <i class="fa fa-search"></i> <span>بحث الفريق</span> 
                        </a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="">
                    <i class="fa fa-cube"></i> <span>{{trans('app.matches')}}</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.matches.create') }}">
                            <i class="fa fa-plus-square"></i> <span>{{trans('app.add')}} {{trans('app.match')}}</span> 
                        </a></li>
                    <li><a href="{{ route('admin.matches.index') }}">
                            <i class="fa fa-cube"></i> <span> {{trans('app.matches')}}</span> 
                        </a></li>
                    <li><a href="{{ route('admin.matches.search') }}">
                            <i class="fa fa-search"></i> <span>{{trans('app.search')}} {{trans('app.matches')}}</span> 
                        </a></li>  
                </ul>
            </li>
            <li class="treeview">
                <a href="">
                    <i class="fa fa-rocket"></i> <span>{{trans('app.champions')}}</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.champions.create') }}">
                            <i class="fa fa-plus-square"></i> <span>{{trans('app.add')}} {{trans('app.champion')}}</span> 
                        </a></li>
                    <li><a href="{{ route('admin.champions.index') }}">
                            <i class="fa fa-rocket"></i> <span> {{trans('app.champions')}}</span> 
                        </a></li>
                    <li><a href="{{ route('admin.champions.search') }}">
                            <i class="fa fa-search"></i> <span>{{trans('app.search')}} {{trans('app.champions')}}</span> 
                        </a></li>  
                </ul>
            </li>
            <li class="treeview">
                <a href="">
                    <i class="fa fa-volume-up"></i> <span>{{trans('app.audiences')}}</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.audiences.create') }}">
                            <i class="fa fa-plus-square"></i> <span>{{trans('app.add')}} {{trans('app.audience')}}</span> 
                        </a></li>
                    <li><a href="{{ route('admin.audiences.index') }}">
                            <i class="fa fa-volume-up"></i> <span> {{trans('app.audiences')}}</span> 
                        </a></li>
                    <li><a href="{{ route('admin.audiences.search') }}">
                            <i class="fa fa-search"></i> <span>{{trans('app.search')}} {{trans('app.audiences')}}</span> 
                        </a></li>  
                </ul>
            </li>
            <li class="treeview">
                <a href="">
                    <i class="fa fa-calendar"></i> <span>{{trans('app.calendar')}}</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.calendar.create') }}">
                            <i class="fa fa-plus-square"></i> <span>{{trans('app.add')}} {{trans('app.calendar')}}</span> 
                        </a></li>
                    <li><a href="{{ route('admin.calendar.index') }}">
                            <i class="fa fa-calendar"></i> <span> {{trans('app.calendar')}}</span> 
                        </a></li>
                    <li><a href="{{ route('admin.calendar.search') }}">
                            <i class="fa fa-search"></i> <span>{{trans('app.search')}} {{trans('app.calendar')}}</span> 
                        </a></li>  
                </ul>
            </li>
            @if($comment_all == 1)
            <!--            <li class="treeview">
                            <a href="">
                                <i class="fa fa-comment"></i> <span>التعليقات</span> 
                                <i class="fa fa-angle-down pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('admin.comments.create') }}">
                                        <i class="fa fa-plus-square"></i> <span>اضافة تعليق </span> 
                                    </a></li>
                                <li><a href="{{ route('admin.comments.index') }}">
                                        <i class="fa fa-comment"></i> <span> التعليقات</span> 
                                    </a></li>
                                <li><a href="{{ route('admin.comments.search') }}">
                                        <i class="fa fa-search"></i> <span>بحث التعليقات</span> 
                                    </a></li>
                            </ul>
                        </li>-->
            @endif
            <li class="treeview">
                <a href="">
                    <i class="fa fa-sitemap"></i> <span>اقسام المتجر</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.categories_product.create') }}">
                            <i class="fa fa-plus-square"></i> <span>اضافة قسم رئيسى</span> 
                        </a></li>
                    <li><a href="{{ route('admin.categories_product.index') }}">
                            <i class="fa fa-cubes"></i> <span> الاقسام الرئيسية للمتجر</span> 
                        </a></li>
                    <li><a href="{{ route('admin.subcategories_product.create') }}">
                            <i class="fa fa-plus-square"></i> <span>اضافة قسم فرعى</span> 
                        </a></li>
                    <li><a href="{{ route('admin.subcategories_product.index') }}">
                            <i class="fa fa-cube"></i> <span> الاقسام الفرعية</span> 
                        </a></li>
                    <li><a href="{{ route('admin.allcategories_product.search') }}">
                            <i class="fa fa-search"></i> <span>بحث اقسام المتجر</span> 
                        </a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="">
                    <i class="fa fa-feed"></i> <span> {{$fees_title}}</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.fees.create') }}">
                            <i class="fa fa-plus-square"></i> <span>اضافة جديدة</span> 
                        </a></li>
                    <li><a href="{{ route('admin.fees.index') }}">
                            <i class="fa fa-feed"></i> <span>{{$fees_title}} </span> 
                        </a></li>
                    <li><a href="{{ route('admin.fees.search') }}">
                            <i class="fa fa-search"></i> <span>بحث {{$fees_title}}</span> 
                        </a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="">
                    <i class="fa fa-product-hunt"></i> <span> {{$product_title}}</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.products.create') }}">
                            <i class="fa fa-plus-square"></i> <span>اضافة جديدة</span> 
                        </a></li>
                    <li><a href="{{ route('admin.products.index') }}">
                            <i class="fa fa-product-hunt"></i> <span>{{$product_title}} </span> 
                        </a></li>
                    <li><a href="{{ route('admin.products.search') }}">
                            <i class="fa fa-search"></i> <span>بحث {{$product_title}}</span> 
                        </a></li>
                    <li><a href="{{ route('admin.productcomments.index') }}">
                            <i class="fa fa-comment"></i> <span> تعليقات المنتجات</span> 
                        </a></li>
                    <li><a href="{{ route('admin.productcomments.search') }}">
                            <i class="fa fa-search"></i> <span>بحث تعليقات المنتجات</span> 
                        </a></li>  
                </ul>
            </li>
            @endif
            @if($access_all == 1)
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-asterisk"></i> <span>اعدادات  الموقع/الصفحات</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.options') }}">
                            <i class="fa fa-asterisk"></i> <span>الاعدادات العامة</span> 
                        </a></li>
                    <li><a href="{{ route('admin.pages.about') }}">
                            <i class="fa fa-support"></i> <span>{{$about_title}}</span> 
                        </a></li>
                    <li><a href="{{ route('admin.pages.contact') }}">
                            <i class="fa fa-envelope"></i> <span> {{$contact_title}}</span> 
                        </a></li>
                    <li><a href="{{ route('admin.pages.terms') }}">
                            <i class="fa fa-rocket"></i> <span> {{$terms_title}}</span> 
                        </a></li>
                    <!--all pages site-->
                </ul>
            </li>
            @endif
            @if($contact_all == 1)
            <li class="treeview">
                <a href="{{ route('admin.contacts.type','contact') }}">
                    <i class="fa fa-envelope-open"></i> <span>رسائل  {{$contact_title}}</span> 
                </a>
            </li>
            @endif
            <li class="treeview">
                <a href="">
                    <i class="fa fa-eercast"></i> <span>رسائل الموقع والموبايل </span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.apimessages.create') }}">
                            <i class="fa fa-plus-square"></i> <span>اضافة جديدة</span> 
                        </a></li>
                    <li><a href="{{ route('admin.apimessages.index') }}">
                            <i class="fa fa-eercast"></i> <span>رسائل الموقع والموبايل </span> 
                        </a></li>
                    <li><a href="{{ route('admin.apimessages.search') }}">
                            <i class="fa fa-search"></i> <span>بحث رسائل الموقع والموبايل  </span> 
                        </a></li>
                </ul>
            </li>
            @if($user_all == 1)
            <li class="treeview">
                <a href="">
                    <i class="fa fa-group"></i> <span>الاعضاء</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    @if($access_all == 1)
                    <li><a href="{{ route('admin.permission.create') }}">
                            <i class="fa fa-plus-square"></i> <span>اضافة صلاحية</span> 
                        </a></li>
                    <li><a href="{{ route('admin.roles.create') }}">
                            <i class="fa fa-plus-square"></i> <span>اضافة وظيفة</span> 
                        </a></li>
                    <li><a href="{{ route('admin.roles.index') }}">
                            <i class="fa fa-user-secret"></i> <span> وظائف الاعضاء</span> 
                        </a></li>
                    @endif
                    <li><a href="{{ route('admin.users.create') }}">
                            <i class="fa fa-plus-square"></i> <span>اضافة عضو</span> 
                        </a></li>
                    <li><a href="{{ route('admin.users.index') }}">
                            <i class="fa fa-users"></i> <span>كل الاعضاء</span> 
                        </a></li>
                    <li><a href="{{ route('admin.users.search') }}">
                            <i class="fa fa-search"></i> <span>بحث الاعضاء</span> 
                        </a></li>
                </ul>
            </li>
            @endif
            @if($access_all == 1)
            <li class=" treeview">
                <!--{{ route('admin.index') }}-->
                <a href="">
                    <i class="fa fa-dashboard"></i> <span>الاحصائيات و التقارير</span>
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.statisticsusers') }}">
                            <i class="fa fa-users"></i> <span>احصائيات الاعضاء  </span> 
                        </a></li>
                </ul>
            </li>

            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>