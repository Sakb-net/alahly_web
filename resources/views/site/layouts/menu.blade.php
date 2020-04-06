<li @if(isset($activ_menu)&&$activ_menu==1) class="active" @endif><a href="{{ route('home') }}">الرئيسية</a></li>
<li @if(isset($activ_menu)&&$activ_menu==2) class="active" @endif><a href="{{ route('about') }}">عن النادي</a></li>
<!--<li @if(isset($activ_menu)&&$activ_menu==3) class="active" @endif><a href="tickets.index">احجز تذكرتك</a></li>-->
<li class="dropdown @if(isset($activ_menu)&&in_array($activ_menu,[4,41,42,43])) active @endif">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">الأخبار</a>
    <ul class="dropdown-menu">
        <li><a href="{{ route('news.index') }}" @if(isset($activ_menu)&&$activ_menu==41) class="active_subli" @endif >أخبار النادي</a></li>
        <li><a href="{{ route('gallery.index') }}" @if(isset($activ_menu)&&$activ_menu==42) class="active_subli" @endif >ألبومات الصور</a></li>
        <li><a href="{{ route('videos.index') }}" @if(isset($activ_menu)&&$activ_menu==43) class="active_subli" @endif >مكتبة الفيديوهات</a></li>
    </ul>
</li>
<li class="dropdown @if(isset($activ_menu)&&$activ_menu==5) active @endif">
    <a href="{{route('categories.index')}}" class="dropdown-toggle" data-toggle="dropdown">المتجر</a>
    <ul class="dropdown-menu">
        <li><a href="{{route('categories.index')}}">كل المنتجات</a></li>
        @foreach($categories_product as $keycatprod=>$val_catprod)
        @if(count($val_catprod->childrens)>0)
        <li class="dropdown">
            <a href="{{ route('categories.category.single',$val_catprod->link) }}" class="dropdown-toggle" data-toggle="dropdown">{{$val_catprod->name}}</a>
            <ul class="dropdown-menu animated fadeOutUp">
                @foreach($val_catprod->childrens as $keycat2=>$val_cat2)
                <li><a href="{{ route('categories.category.single',$val_cat2->link) }}">{{$val_cat2->name}}</a></li>
                <!--                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">sub2</a>
                                    <ul class="dropdown-menu animated">
                                        <li><a href="#">p2</a></li>
                                    </ul>
                                </li>-->
                @endforeach
            </ul>
        </li>
        @else
        <li><a href="{{ route('categories.category.single',$val_catprod->link) }}">{{$val_catprod->name}}</a></li>
        @endif
        @endforeach
    </ul>
</li>
<li class="dropdown @if(isset($activ_menu)&&$activ_menu==6) active @endif">
    <a class="dropdown-toggle" data-toggle="dropdown">الفريق</a>
    <ul class="dropdown-menu">
        <!--<li><a href="{{route('teams.index')}}">كل الفريق</a></li>-->
        @foreach($categories_team as $keycat_team=>$val_cat_team)
        @if(count($val_cat_team->childrens)>0)
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown">{{$val_cat_team->name}}</a>
            <ul class="dropdown-menu animated fadeOutUp">
                @foreach($val_cat_team->childrens as $key_cat_team2=>$val_cat_team2)
                <li><a href="{{ route('teams.teams.team.single',[$val_cat_team->link,$val_cat_team2->link]) }}">{{$val_cat_team2->name}}</a></li>
                <!--                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">sub2</a>
                                    <ul class="dropdown-menu animated">
                                        <li><a href="#">p2</a></li>
                                    </ul>
                                </li>-->
                @endforeach
            </ul>
        </li>
        @else
        <li><a href="{{ route('teams.teams.single',$val_cat_team->link) }}">{{$val_cat_team->name}}</a></li>
        @endif
        @endforeach
    </ul>
</li>
<li class="dropdown @if(isset($activ_menu)&&in_array($activ_menu,[7,71,72])) active @endif">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">المباريات</a>
    <ul class="dropdown-menu">
        <li><a href="{{ route('matches.next') }}" @if(isset($activ_menu)&&$activ_menu==71) class="active_subli" @endif>المباريات القادمة</a></li>
        <li><a href="{{ route('matches.previous') }}" @if(isset($activ_menu)&&$activ_menu==72) class="active_subli" @endif>نتائج المباريات السابقة</a></li>
    </ul>
</li>
<li @if(isset($activ_menu)&&$activ_menu==8) class="active" @endif><a href="{{ route('champions') }}">البطولات</a></li>
<li @if(isset($activ_menu)&&$activ_menu==9) class="active" @endif><a href="{{ route('audience') }}">مجلس الجمهور</a></li>
<!--<li @isset($activ_menu)&&if($activ_menu==10) class="active" @endif><a href="{{ route('game') }}">لعبة بلوت</a></li>-->
<li @if(isset($activ_menu)&&$activ_menu==11) class="active" @endif><a href="{{ route('calendar') }}">الروزنامة</a></li>
<li @if(isset($activ_menu)&&$activ_menu==12) class="active" @endif><a href="{{ route('contact') }}">اتصل بنا</a></li>