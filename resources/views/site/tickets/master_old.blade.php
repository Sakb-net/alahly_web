@extends('site.layouts.app')
@section('content')
<div class="myinner-banner">
    <div class="opacity">
        <h2>حجز التذاكر</h2>
    </div>
</div>
<section class="section-padding">
    <div class="container">
        <div class="stadium">
            <svg class="map-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 10240 7680" style="background-image:url(/images/stadium.svg);transform:rotate(0deg);">
                <!--============ polygons ============-->
                <g class="polygons">
                    @foreach($data as $key_sec=>$val_sec)
                        <a class="get_section_modal" data-match="{{$match['link']}}" data-link="{{$val_sec->link}}">
                            
                            @if($key_sec==0)
                            <path class="block is-available is-filtered minimum" d="M6286.7,1782.15L6286.7,2075.1L6720.099999999999,2075.1L6720.099999999999,1782.15z">
                            @elseif($key_sec==1)
                            <path class="block is-available is-filtered minimum" d="M5854.8,1782.15L5854.8,2075.1L6286.650000000001,2075.1L6286.650000000001,1782.15z">
                            @elseif($key_sec==2)
                            <path class="block" d="M6720.1,1782.15L6720.1,2075.1L7215.200000000001,2075.1L7215.200000000001,1782.15z">
                            @elseif($key_sec==3)
                            <path class="block is-available is-filtered minimum" d="M7457,260.4L7457,596.9L7626.849999999999,596.9L7626.849999999999,1048.15L8222.08,1048.15L8260.444,598.73L8289.333,260.4L7457,260.4z">
                            @elseif($key_sec==4)
                            <path class="block is-available is-filtered middle" d="M9997.669999999998,1505.05L8414.8,2173.24L8434.96,2255.5299999999997L8434.939999999999,2342.38L10112.96,2342.38L10112.96,2051.66L9997.669999999998,1505.05z">
                            @elseif($key_sec==5)
                            <path class="block is-available is-filtered middle" d="M9538,812.05L8485.3,1825.6799999999998L8650.179999999998,2073.8199999999997L9997.679999999998,1505.0500000000002L9989.55,1466.52L9538.03,812.07z">
                            @elseif($key_sec==6)
                            <path  class="block is-available is-filtered minimum"  data-section-id="s_34" d="M3736.95,1782.15L3736.95,2075.1L4165.55,2075.1L4165.55,1782.15z">
                            @elseif($key_sec==7)
                            <path class="block is-available is-filtered middle" d="M8455.24,5957.05L8455.24,6109.25L8440.4,6165.45L9990.94,6811.43L10112.99,6217.21L10112.99,5957.05z">
                            @elseif($key_sec==8)
                            <path class="block is-available" d="M3300.5,1782.15L3300.5,2075.1L3736.999999999998,2075.1L3736.999999999998,1782.15z">
                            @elseif($key_sec==9)
                            <path class="block is-available is-filtered middle" d="M8503,5286.9L8503,5396.699999999999L8325.55,5396.699999999999L8325.55,5959.049999999998L8325.55,6101.099999999999L8313.262999999999,6115.32L8268.23,6167.449999999999L8229.3,6212.369999999999L8319.381,6304.021999999999L8440.415,6165.433L8455.25,6109.249999999999L8455.25,5957.049999999999L10113,5957.049999999999L10113,5286.9L8503,5286.9z">
                            @elseif($key_sec==10)
                            <path class="block" d="M5502.15,1782.15L5502.15,2075.1L5854.8499999999985,2075.1L5854.8499999999985,1782.15z">
                            @elseif($key_sec==11)
                            <path class="block is-available is-filtered middle" d="M4165.55,1782.15L4165.55,2075.1L4526.1,2075.1L4526.1,1782.15z">
                            @elseif($key_sec==12)
                            <path class="block is-available is-filtered middle" d="M8637.52,6247.55L8483.1,6470.59L9318.892850008462,7318.242850008462L9732.342850008465,6705.292850008462z">
                            @elseif($key_sec==13)
                            <path class="block is-available is-filtered minimum" d="M8896.756381596619,386.15L8896.756381596619,386.28L8892.29638159662,396.66L8241.85,1968.9936184033795L8294.306381596618,2009.5300000000002L9537.93638159662,812.05L8896.916381596619,386.1799999999999z">
                            @elseif($key_sec==14)
                            <path class="block is-available is-filtered minimum" d="M8325.55,2902.2L8325.55,3791.3L8503,3791.3L8503,3494.7L8704.7,3494.7L8704.7,3626.6999999999994L10113,3626.6999999999994L10113,3006.4999999999995L8503,3006.4999999999995L8503,2902.2L8325.55,2902.2z">
                            @elseif($key_sec==15)
                            <path class="block is-available is-filtered minimum" d="M8241.75,1968.95L8201.85,2053.3823529411766L8238.741647058823,2075.0266470588235L8325.497647058823,2210.8086470588237L8325.497647058823,2344.3376470588237L8325.497647058823,2902.137647058824L8502.947647058823,2902.137647058824L8502.947647058823,3006.4376470588236L10112.947647058823,3006.4376470588236L10112.947647058823,2342.3376470588237L8434.928647058823,2342.3376470588237L8434.947647058823,2255.487647058824L8414.197647058823,2170.7876470588235L8345.447647058823,2053.1376470588234L8294.297647058822,2009.4876470588235z">
                            @elseif($key_sec==16)
                            <path class="block is-available is-filtered minimum" d="M2792.7,1782.15L2792.7,2075.1L3300.5000000000005,2075.1L3300.5000000000005,1782.15z">
                            @elseif($key_sec==17)
                            <path class="block is-available is-filtered middle" d="M8325.55,4052L8325.55,5396.7L8503,5396.7L8503,5286.900000000001L10113,5286.900000000001L10113,4669.5L8704.7,4669.5L8704.7,4805.299999999999L8503,4805.299999999999L8503,4052L8325.55,4052z">
                            @elseif($key_sec==18)
                            <path class="block" d="M2300.85,1782.15L2300.85,2075.1L2792.6999999999994,2075.1L2792.6999999999994,1782.15z">
                            @elseif($key_sec==19)
                            <path class="block is-available is-filtered minimum" d="M8704.65,3626.7L8704.65,4669.5L10112.95,4669.5L10112.95,3626.7z">
                            @elseif($key_sec==20)
                            <path class="block is-available is-filtered minimum" d="M1602.75,1211.1C1713.0400000000002,1417.86 1821.98,1622.28 1906.95,1782.15L2561.13,1782.15L2561.13,1211.1z">
                            @elseif($key_sec==21)
                            <path class="block is-ga is-available" d="M173,4479L173,5295.95L1728.7400000000002,5295.95L1728.7299999999998,4479z">
                            @elseif($key_sec==22)
                            <path class="block is-available is-filtered middle" d="M8289.287149991538,260.4L8145.1,1949.7428500084616L8241.79361840338,1968.9936184033795L8892.347149991538,396.65L8896.807149991539,386.27L8896.807149991539,386.14z">
                            @elseif($key_sec==23)
                            <path class="block is-available is-filtered middle" d="M1906.95,1782.15C1983.65,1926.44 2040.83,2034.43 2061.87,2075.1L2300.8300000000004,2075.1L2300.8300000000004,1782.15z">
                            @elseif($key_sec==24)
                            <path class="block is-available" d="M7454.55,1211.1L7454.55,1782.15L8159.41,1782.15L8208.17,1211.1z">
                            @elseif($key_sec==25)
                            <path class="block is-available is-filtered minimum" d="M6759,1211.1L6759,1782.15L7454.55,1782.15L7454.55,1211.1z">
                            @elseif($key_sec==26)
                            <path class="block is-available is-filtered minimum" d="M5327.8,260.4L5327.96981016711,632.9198101671099L5443.11981016711,632.8198101671098L5443.100000000001,1048.15L6205.35,1048.15L6205.35,596.9L6047.950000000001,596.9L6047.950000000001,260.4z">
                            @elseif($key_sec==27)
                            <path class="block is-available is-filtered minimum" d="M4688.65,260.4L4688.65,632.860835499871L4575.55,632.860835499871L4575.55,977.6499893132732L5443.15,977.6499893132732L5443.15,632.860835499871L5327.85,632.860835499871L5327.85,260.4z">
                            @elseif($key_sec==28)
                            <path class="block is-available" d="M6750.05,260.4L6750.05,596.9L6912.200000000001,596.9L6912.200000000001,1048.15L7626.849999999999,1048.15L7626.849999999999,596.9L7457,596.9L7457,260.4L6750.05,260.4z">
                            @elseif($key_sec==29)
                            <path class="block is-available is-filtered minimum" d="M1162.95,260.4L1162.95,387.32L1162.95,387.32C1192.404,442.453 1230.107,513.02 1273.339,593.958L1275.475,597.958C1345.203,728.499 1429.075,885.5689999999998 1515.83,1048.15L1714.5,1048.15L1714.5,596.9L1872.95,596.9L1872.95,260.4L1162.95,260.4z">
                            @elseif($key_sec==30)
                            <path class="block is-available is-filtered minimum" d="M6048,260.4L6048,596.9000000000001L6205.4,596.9000000000001L6205.4,1048.15L6912.200000000001,1048.15L6912.200000000001,596.9000000000001L6750.05,596.9000000000001L6750.05,260.4L6048,260.4z">
                            @elseif($key_sec==31)
                            <path class="block is-available is-filtered minimum" d="M2549.8500000000004,260.4L2549.8500000000004,596.9L2391.75,596.9L2391.75,1048.15L3103.85,1048.15L3103.85,596.9L3264.3,596.9L3264.3,260.4L2549.8500000000004,260.4z">
                            @elseif($key_sec==32)
                            <path class="block is-available is-filtered minimum" d="M1872.95,260.4L1872.95,596.9L1714.5,596.9L1714.5,1048.15L2391.75,1048.15L2391.75,596.9L2549.8500000000004,596.9L2549.8500000000004,260.4L1872.95,260.4z">
                            @elseif($key_sec==33)
                            <path class="block is-available is-filtered minimum" d="M3973.2,260.4L3973.2,596.9L3814.7,596.9L3814.7,1048.15L4575.55,1048.15L4575.519810167109,632.8698101671098L4688.71981016711,632.8198101671098L4688.65,260.4z">
                            @elseif($key_sec==34)
                            <path class="block is-available is-filtered minimum" d="M3264.3,260.4L3264.3,596.9L3103.85,596.9L3103.85,1048.15L3814.7,1048.15L3814.7,596.9L3973.2,596.9L3973.2,260.4L3264.3,260.4z">
                            @elseif($key_sec==35)
                            <path class="block is-available" d="M6028.3,1211.1L6028.3,1782.15L6759,1782.15L6759,1211.1z">
                            @elseif($key_sec==36)
                            <path class="block is-available is-filtered middle" d="M173,5935.2L173,6131.82L275.68848977129414,6626.4384897712935L1481.046521806437,6126.009406389775L1509.238489771294,6185.638489771294L1601.288489771294,6126.088489771294L1601.3000000000002,5935.2z">
                            @elseif($key_sec==37)
                            <path class="block is-available is-filtered minimum" d="M1251.3884897712942,6222.45L432.65,6560.953592058356L787.961510228706,7076.953592058356L1414.1115102287058,6470.603592058355z">
                            @elseif($key_sec==38)
                            <path class="block is-available" d="M6597.15,6167.45L6597.15,6274.449999765902L6810.325499778742,6274.449999765902L7357.14991266878,6274.449999765902L7357.14991266878,6167.45z">
                            @elseif($key_sec==39)
                            <path  data-section-id="s_93" title="135" class="block is-available is-filtered minimum" d="M173,5295.95L173,5935.2L1601.3000000000002,5935.2L1601.3000000000002,6048.45L1728.75,6048.45L1728.75,5933.2L1728.74,5295.95z">
                            @elseif($key_sec==40)
                            <path class="block is-available is-filtered minimum" d="M1596.988489771294,6295.9L902.15,6966.442081829649L1269.6515102287058,7231.503592058354L1702.3315102287056,7317.673592058354L1797.5815102287058,7317.673592058354L1797.5384897712945,6366.838489771294L1596.988489771294,6295.9z">
                            @elseif($key_sec==41)
                            <path class="block is-available is-filtered minimum" d="M3977.05,1211.1L3977.05,1782.15L4629,1782.15L4629,1211.1z">
                            @elseif($key_sec==42)
                            <path class="block is-available is-filtered minimum" d="M3260.75,1211.1L3260.75,1782.15L3977.000000000001,1782.15L3977.000000000001,1211.1z">
                            @elseif($key_sec==43)
                            <path class="block is-ga" d="M984.5,2230.5L984.41,3277.7099999999996L916.2999999999998,3312.8500000000004L916.34,2230.79L984.5,2230.5zM553.8,1627L553.8,3499.1L984.5399999999998,3278.3599999999997L984.5,2242.96L984.5,2231.01L1081.1,1994.45L1081.1,1627z">
                            @elseif($key_sec==44)
                            <path class="block is-available is-filtered minimum" d="M5382.45,1211.1L5382.45,1782.15L6028.3,1782.15L6028.3,1211.1z">
                            @elseif($key_sec==45)
                            <path class="block is-available" d="M4629,1211.1L4629,1782.15L5382.45,1782.15L5382.45,1211.1z">
                            @elseif($key_sec==46)
                            <path class="block" d="M1761.25,6167.45L1761.25,6277.3499999999985L2553.65,6277.3499999999985L2553.65,6167.45z">
                            @elseif($key_sec==47)
                            <path class="block" d="M1728.7199999999998,3060.85L1426.69,3215.68L1426.69,3339.04L643.85,3740.09L643.89,3871.2L1728.7199999999998,3871.22L1728.7199999999998,3060.85z">
                            @elseif($key_sec==48)
                            <path class="block is-available" d="M2553.65,6167.45L2553.65,6277.449900000091L3238.649923446587,6277.449900000091L3238.649923446587,6167.45z">
                            @elseif($key_sec==49)
                            <path class="block is-ga is-available" d="M373.96000000000004,3871.25L374,4148.87L173,4272.13L173,4479L1728.7299999999996,4479L1728.7299999999996,3871.25z">
                            @elseif($key_sec==50)
                            <path class="block is-available is-filtered minimum" d="M2561.15,1211.1L2561.15,1782.15L3260.7999999999997,1782.15L3260.7999999999997,1211.1z">
                            @elseif($key_sec==51)
                            <path class="block" d="M916.3425726947124,2230.7925726947124L984.5,2230.5L984.4074273052876,3277.707427305284L916.3,3312.8499999999976z">
                            @elseif($key_sec==52)
                            <path class="block" d="M1426.65,2512.4L1728.75,2512.4L1728.7130553777238,3010.8130553777237L1426.8630553777236,3165.713055377724z">
                            @elseif($key_sec==53)
                            <path class="block is-available" d="M1728.7099999999998,2061.55L1528.07,2061.625860329016L1426.65,2157.7883098972848L1426.66,2512.350005174589L1728.7099999999998,2512.350005174589L1728.7099999999998,2074.2091924044616L1728.7099999999998,2061.55z">
                            @elseif($key_sec==54)
                            <path class="block is-available" d="M7559.35,6274.25L7559.35,7318.099999999999L8073.5,7318.099999999999L8073.5,6274.25z">
                            @elseif($key_sec==55)
                             <path class="block is-available is-filtered minimum" d="M8295.342850008461,6275.75L8073.642850008461,6361.049999999999L8073.5,7317.967149991539L8630.44,7317.967149991539L9045.1,7042.237149991538z">
                            @elseif($key_sec==56)
                            <path class="block is-available is-filtered minimum" d="M5962.4,6167.45L5962.4,6274.2L6126.15,6274.2L6126.15,7318.099999999999L6841.25,7318.099999999999L6841.25,6274.2L6597.150000000001,6274.2L6597.150000000001,6167.45L5962.4,6167.45z">
                            @elseif($key_sec==57)
                            <path class="block is-available" d="M6841.2,6274.25L6841.2,7318.099999999999L7559.300000000001,7318.099999999999L7559.300000000001,6274.25z">
                            @elseif($key_sec==58)
                            <path class="block is-available is-filtered minimum" d="M1797.65,6277.3L1797.65,7318.05L2464.75,7318.05L2464.75,6277.3z">
                            @elseif($key_sec==59)
                            <path class="block is-available is-filtered minimum" d="M2464.75,6277.3L2464.75,7318.05L3173.0499999999997,7318.05L3173.0499999999997,6277.3z">
                            @elseif($key_sec==60)
                            <path class="block" d="M7661.05,1782.15L7661.05,2075.0999999999995L8024.330000000001,2075.0999999999995L8049.32,1782.15z">
                            @elseif($key_sec==61)
                            <path class="block is-available is-filtered minimum" d="M4595.6,6398.9L4595.6,7318.099999999999L5413.8,7318.099999999999L5413.8,6398.9z">
                            @elseif($key_sec==62)
                            <path class="block" d="M7215.2,1782.15L7215.2,2075.1L7660.049999999999,2075.1L7660.049999999999,1782.15z">
                            @elseif($key_sec==63)
                            <path class="block is-available is-filtered minimum" d="M5962.3,6274.2L5962.3,6398.9L5413.8,6398.9L5413.8,7318.099999999999L6126.15,7318.099999999999L6126.15,6274.2z">
                            @elseif($key_sec==64)
                            <path class="block is-available is-filtered minimum" d="M3448.4500000000003,6167.45L3448.4500000000003,6277.35L3173.05,6277.35L3173.05,7318.099999999999L3881.4,7318.099999999999L3881.4,6277.35L4052.8,6277.35L4052.8,6167.45L3448.4500000000003,6167.45z">
                            @elseif($key_sec==65)
                            <path class="block is-available is-filtered middle" d="M7356.95,6167.454037267081L7357.10403726708,6274.30403726708L7559.345962732919,6274.2L8073.495962732919,6274.25L8102.295962732918,6274.150000000001L8102.295962732918,6167.45z">
                            @elseif($key_sec==66)
                            <path class="block is-available" d="M3881.4,6277.3L3881.4,7318.05L4595.6,7318.05L4595.6,6398.85L4052.8,6398.85L4052.8,6277.3z">
                            @endif
                            <title>{{$val_sec->name}} &nbsp; {{$val_sec->content}}</title>
                            </path>
                        </a>
                    @endforeach
                </g>
                <!--============ end polygons ============-->

                <!--============ labels ============-->
                <g class="labels">
                    @foreach($data as $key_sec=>$val_sec)
                    <a class="get_section_modal" data-match="{{$match['link']}}" data-link="{{$val_sec->link}}">
                        <text class="label"  font-size="200" @if($key_sec==43) transform="rotate(-90,663,2492)" font-size="120" @elseif($key_sec==51) transform="rotate(-90,903,2763)" font-size="80" @elseif($key_sec==52) transform="rotate(-90,1461,2801)" @elseif($key_sec==53) transform="rotate(-90,1462,2287)" @else transform="" @endif>
                            @if($key_sec==0)
                              <tspan dy="1em" x="6503" y="1812">
                            @elseif($key_sec==1)
                            <tspan dy="1em" x="6070" y="1812">
                            @elseif($key_sec==2)
                            <tspan dy="1em" x="6967" y="1812">
                            @elseif($key_sec==3)
                            <tspan dy="1em" x="7950" y="508">
                            @elseif($key_sec==4)
                            <tspan dy="1em" x="9434" y="1936">
                            @elseif($key_sec==5)
                            <tspan dy="1em" x="9266" y="1374">
                            @elseif($key_sec==6)
                            <tspan dy="1em" x="3951" y="1812">
                            @elseif($key_sec==7)
                            <tspan dy="1em" x="9376" y="6110">
                            @elseif($key_sec==8)
                            <tspan dy="1em" x="3518" y="1812">
                            @elseif($key_sec==9)
                            <tspan dy="1em" x="9268" y="5498">
                            @elseif($key_sec==10)
                            <tspan dy="1em" x="5678" y="1812">
                            @elseif($key_sec==11)
                            <tspan dy="1em" x="4345" y="1812">
                            @elseif($key_sec==12)
                            <tspan dy="1em" x="9064" y="6574">
                            @elseif($key_sec==13)
                            <tspan dy="1em" x="8826" y="1032">
                            @elseif($key_sec==14)
                            <tspan dy="1em" x="9268" y="3199">
                            @elseif($key_sec==15)
                            <tspan dy="1em" x="9268" y="2557">
                            @elseif($key_sec==16)
                            <tspan dy="1em" x="3046" y="1812">
                            @elseif($key_sec==17)
                            <tspan dy="1em" x="9268" y="4854">
                            @elseif($key_sec==18)
                            <tspan dy="1em" x="2546" y="1812">
                            @elseif($key_sec==19)
                            <tspan dy="1em" x="9408" y="4032">
                            @elseif($key_sec==20)
                            <tspan dy="1em" x="2153" y="1363">
                            @elseif($key_sec==21)
                            <tspan dy="1em" x="950" y="4771">
                            @elseif($key_sec==22)
                            <tspan dy="1em" x="8459" y="738">
                            @elseif($key_sec==23)
                            <tspan dy="1em" x="2159" y="1812">
                            @elseif($key_sec==24)
                            <tspan dy="1em" x="7819" y="1377">
                            @elseif($key_sec==25)
                            <tspan dy="1em" x="7106" y="1380">
                            @elseif($key_sec==26)
                            <tspan dy="1em" x="5767" y="538">
                            @elseif($key_sec==27)
                            <tspan dy="1em" x="5008" y="468">
                            @elseif($key_sec==28)
                            <tspan dy="1em" x="7199" y="538">
                            @elseif($key_sec==29)
                            <tspan dy="1em" x="1499" y="371">
                            @elseif($key_sec==30)
                            <tspan dy="1em" x="6500" y="538">
                            @elseif($key_sec==31)
                            <tspan dy="1em" x="2795" y="538">
                            @elseif($key_sec==32)
                            <tspan dy="1em" x="2110" y="538">
                            @elseif($key_sec==33)
                            <tspan dy="1em" x="4240" y="538">
                            @elseif($key_sec==34)
                            <tspan dy="1em" x="3497" y="538">
                            @elseif($key_sec==35)
                            <tspan dy="1em" x="6393" y="1380">
                            @elseif($key_sec==36)
                            <tspan dy="1em" x="760" y="6071">
                            @elseif($key_sec==37)
                            <tspan dy="1em" x="948" y="6484">
                            @elseif($key_sec==38)
                            <tspan dy="1em" x="6977" y="6163">
                            @elseif($key_sec==39)
                            <tspan dy="1em" x="967" y="5505">
                            @elseif($key_sec==40)
                            <tspan dy="1em" x="1477" y="6694">
                            @elseif($key_sec==41)
                            <tspan dy="1em" x="4303" y="1380">
                            @elseif($key_sec==42)
                            <tspan dy="1em" x="3618" y="1380">
                            @elseif($key_sec==43)
                            <tspan dy="1em" x="650" y="2492">
                            @elseif($key_sec==44)
                            <tspan dy="1em" x="5705" y="1380">
                            @elseif($key_sec==45)
                            <tspan dy="1em" x="5005" y="1380">
                            @elseif($key_sec==46)
                            <tspan dy="1em" x="2157" y="6164">
                            @elseif($key_sec==47)
                            <tspan dy="1em" x="1330" y="3525">
                            @elseif($key_sec==48)
                            <tspan dy="1em" x="2896" y="6164">
                            @elseif($key_sec==49)
                            <tspan dy="1em" x="967" y="4069">
                            @elseif($key_sec==50)
                            <tspan dy="1em" x="2910" y="1380">
                            @elseif($key_sec==51)
                            <tspan dy="1em" x="903" y="2763">
                            @elseif($key_sec==52)
                            <tspan dy="1em" x="1461" y="2801">
                            @elseif($key_sec==53)
                            <tspan dy="1em" x="1462" y="2287">
                            @elseif($key_sec==54)
                            <tspan dy="1em" x="7816" y="6680">
                            @elseif($key_sec==55)
                            <tspan dy="1em" x="8395" y="6736">
                            @elseif($key_sec==56)
                            <tspan dy="1em" x="6486" y="6680">
                            @elseif($key_sec==57)
                            <tspan dy="1em" x="7200" y="6680">
                            @elseif($key_sec==58)
                            <tspan dy="1em" x="2131" y="6682">
                            @elseif($key_sec==59)
                            <tspan dy="1em" x="2818" y="6682">
                            @elseif($key_sec==60)
                            <tspan dy="1em" x="7849" y="1822">
                            @elseif($key_sec==61)
                            <tspan dy="1em" x="5004" y="6742">
                            @elseif($key_sec==62)
                            <tspan dy="1em" x="7437" y="1812">
                            @elseif($key_sec==63)
                            <tspan dy="1em" x="5778" y="6726">
                            @elseif($key_sec==64)
                            <tspan dy="1em" x="3525" y="6682">
                            @elseif($key_sec==65)
                            <tspan dy="1em" x="7729" y="6163">
                            @elseif($key_sec==66)
                            <tspan dy="1em" x="4230" y="6726">
                            @endif
                                {{$val_sec->name}}</tspan>
                        </text>
                    </a>
                    @endforeach
                </g>
            </svg>
        </div>
    </div>
</section>
<a data-toggle="modal" class="modal_section" data-target="#myModal"></a>
@include('site.tickets.model')
@endsection
@section('after_head')

@stop  
@section('after_foot')

@stop  