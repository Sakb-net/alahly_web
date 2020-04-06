
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
            <!--            <li class="treeview">
                            <a href="{{ route('home') }}" target="_blank">
                                <i class="fa fa-home"></i> <span>الرئيسية</span> 
                            </a>
                        </li>-->
            <!-- active  header -->
            @if($category_all == 1)
            <li class="treeview">
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
            </li>
            <!--            <li class="treeview">
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
                            </ul>
                        </li>-->
            <!--all categories-->
            <li class="treeview">
                <a href="">
                    <i class="fa fa-sitemap"></i> <span>الاقسام</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.categories.create') }}">
                            <i class="fa fa-plus-square"></i> <span>اضافة قسم رئيسى</span> 
                        </a></li>
                    <li><a href="{{ route('admin.categories.index') }}">
                            <i class="fa fa-cubes"></i> <span> الاقسام الرئيسية</span> 
                        </a></li>
                    <!--                    <li><a href="{{ route('admin.subcategories.create') }}">
                                                <i class="fa fa-plus-square"></i> <span>اضافة قسم فرعى</span> 
                                            </a></li>
                                        <li><a href="{{ route('admin.subcategories.index') }}">
                                                <i class="fa fa-cube"></i> <span> الاقسام الفرعية</span> 
                                            </a></li>-->
                    <li><a href="{{ route('admin.allcategories.search') }}">
                            <i class="fa fa-search"></i> <span>بحث الاقسام</span> 
                        </a></li>
                </ul>
            </li>
            <!--end categories-->
            @endif
            @if($post_all == 1)  
            <li class="treeview">
                <a href="">
                    <i class="fa fa-star"></i> <span> {{$about_title}}</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.pages.about') }}">
                            <i class="fa fa-support"></i> <span>{{$about_title}}</span> 
                        </a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="">
                    <i class="fa fa-envelope"></i> <span>{{$contact_title}}</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">

                    <li><a href="{{ route('admin.pages.contact') }}">
                            <i class="fa fa-envelope"></i> <span> {{$contact_title}}</span> 
                        </a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="">
                    <i class="fa fa-gift"></i> <span> {{$service_title}}</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.posts.creat','service') }}">
                            <i class="fa fa-plus-square"></i> <span>اضافة جديدة</span> 
                        </a></li>
                    <li><a href="{{ route('admin.posts.type','service') }}">
                            <i class="fa fa-gift"></i> <span>{{$service_title}} </span> 
                        </a></li>
                    <li><a href="{{ route('admin.posts.search','service') }}">
                            <i class="fa fa-search"></i> <span>بحث {{$service_title}}</span> 
                        </a></li>
                </ul>
            </li>

            @endif
            @if($access_all == 1)
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-asterisk"></i> <span>اعدادات  الموقع</span> 
                    <i class="fa fa-angle-down pull-right"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('admin.options') }}">
                            <i class="fa fa-asterisk"></i> <span>الاعدادات العامة</span> 
                        </a></li>
                    <!--all pages site-->
                </ul>
            </li>
            @endif
            <!--            @if($message_all == 1)
                        <li class="treeview">
                            <a href="">
                                <i class="fa fa-envelope-o"></i> <span></span> 
                            </a>
                        </li>-->
            @endif
            @if($contact_all == 1)
            <li class="treeview">
                <a href="{{ route('admin.contacts.type','contact') }}">
                    <i class="fa fa-envelope-open"></i> <span>رسائل  {{$contact_title}}</span> 
                </a>
            </li>
            @endif
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
                    <!--                    <li><a href="{{ route('admin.statisticspublic') }}">
                                                <i class="fa fa-eraser"></i> <span>الاحصائيات العامة</span> 
                                            </a></li>-->
                    <!--                    <li><a href="{{ route('admin.statisticsorders') }}">
                                               <i class="fa fa-asterisk"></i> <span>احصائيات الاشتركات والماليه</span> 
                                           </a></li>-->
                </ul>
            </li>

            @endif

            <!--            @if($comment_all == 1)
                        <li class="treeview">
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
                        </li>
                        @endif-->


            <!--            @if($tag_all == 1)
                        <li class="treeview">
                            <a href="{{ route('admin.tags.index') }}">
                                الوسوم
                                <i class="fa fa-tags"></i> <span>الكلمات الدلالية</span> 
                            </a>
                        </li>
                        @endif-->
            <!--            @if($search_all == 1)
                        <li class="treeview">
                            <a href="{{ route('admin.searches.index') }}">
                                بحث الاعضاء
                                <i class="fa fa-search"></i> <span>نتائج البحث</span> 
                            </a>
                        </li>
                        @endif-->
            <!-- @if($message_all == 1)
                <li class="treeview">
                    <a href="{{ route('admin.messages.index') }}">
                        <i class="fa fa-envelope-o"></i> <span>الرسائل</span> 
                    </a>
                </li>
                @endif-->
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>