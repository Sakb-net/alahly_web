<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    </head>
    <body>
        <style>
            /* Base */
            @font-face {
                font-family: myFirstFont;
                src: url("{{asset('css/site/email_fonts/ge-ss-two-medium.otf')}}");
            }
            body, body *:not(html):not(style):not(br):not(tr):not(code) {
                /*font-family: Avenir, Helvetica, sans-serif;*/
                font-family: myFirstFont;
                box-sizing: border-box;
            }
            body {
                background-color: #01e0dc; /*#f5f8fa*/
                color: #74787E;
                height: 100%;
                hyphens: auto;
                line-height: 1.4;
                margin: 0;
                -moz-hyphens: auto;
                -ms-word-break: break-all;
                width: 100% !important;
                -webkit-hyphens: auto;
                -webkit-text-size-adjust: none;
                word-break: break-all;
                word-break: break-word;
            }
            p,
            ul,
            ol,
            blockquote {
                line-height: 1.4;
                text-align: left;
            }
            a {
                color: #3869D4;
            }
            a img {
                border: none;
            }
            /* Typography */
            h1 {
                color: #2F3133;
                font-size: 40px;
                font-weight: bold;
                margin-top: 0;
                text-align: center;
            }
            h2 {
                color: #2F3133;
                font-size: 28px;
                font-weight: bold;
                margin-top: 0;
                text-align: center;
            }
            h3 {
                color: #fff;
                font-size: 22px;
                font-weight: bold;
                margin-top: 0;
                text-align: center;
            }
            p {
                color: #74787E;
                font-size: 24px;
                line-height: 1.5em;
                margin-top: 0;
                text-align: center;
            }
            p.sub {
                font-size: 12px;
            }

            img {
                max-width: 100%;
            }
            /* Layout */
            .wrapper {
                background-color: #01e0dc; /*#f5f8fa*/
                margin: 0;
                padding: 0;
                width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 100%;
            }
            .content {
                margin: 0;
                padding: 0;
                width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 100%;
            }
            /* Header */
            .ground-syan{
                background:#01e0dc;
            }
            .header {
                padding: 25px 0;
                text-align: center;
            }
            .header a {
                color: #fff;/*#bbbfc3;*/
                font-size: 19px;
                font-weight: bold;
                text-decoration: none;
                text-shadow: 0 1px 0 white;
            }
            /* Body */
            .body {
                /*background-color: #FFFFFF;*/
                border-bottom: 1px solid #EDEFF2;
                border-top: 1px solid #EDEFF2;
                margin: 0;
                padding: 0;
                width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 100%;
            }
            .inner-body {
                /*background-color: #FFFFFF;*/
                margin: 0 auto;
                padding: 0;
                width: 570px;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 570px;
            }
            /* Subcopy */
            .subcopy-border {
                border-top: 1px solid #01e0dc;
            }
            .subcopy-top {
                padding-top: 25px;
            }
            .subcopy {
                margin-top: 25px;
            }
            .subcopy p {
                font-size: 20px;
            }
            /* Footer */
            .footer {
                margin: 0 auto;
                padding: 0;
                text-align: center;
                width: 570px;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 570px;
            }
            .footer p {
                color: #AEAEAE;
                font-size: 12px;
                text-align: center;
            }
            /* Tables */
            .table table {
                margin: 30px auto;
                width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 100%;
            }
            .table th {
                border-bottom: 1px solid #EDEFF2;
                padding-bottom: 8px;
            }
            .table td {
                color: #74787E;
                font-size: 15px;
                line-height: 18px;
                padding: 10px 0;
            }
            .content-cell {
                padding: 35px;
            }
            .pad-bom {
                padding-bottom: 0px;
            }
            /* Buttons */
            .action {
                margin: 30px auto;
                padding: 0;
                text-align: center;
                width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 100%;
            }
            .button {
                border-radius: 3px;
                /*box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);*/
                box-shadow: 0 2px 3px rgba(0, 0, 0, 0.31);
                color: #FFF;
                display: inline-block;
                text-decoration: none;
                -webkit-text-size-adjust: none;
            }
            .button-blue {
                background-color: #3097D1;
                border-top: 10px solid #3097D1;
                border-right: 18px solid #3097D1;
                border-bottom: 10px solid #3097D1;
                border-left: 18px solid #3097D1;
            }
            .button-green {
                background-color: #01a7a3;
                border-top: 10px solid #01a7a3;
                border-right: 18px solid #01a7a3;
                border-bottom: 10px solid #01a7a3;
                border-left: 18px solid #01a7a3;
            }
            .button-syan {
                background-color: #00c3c0;
                border-top: 10px solid #00c3c0;
                border-right: 18px solid #00c3c0;
                border-bottom: 10px solid #00c3c0;
                border-left: 18px solid #00c3c0;
            }
            .button-syan:focus , .button-syan:active , .button-syan:hover  {
                background-color: #01e0dc;
                border-top: 10px solid #01e0dc;
                border-right: 18px solid #01e0dc;
                border-bottom: 10px solid #01e0dc;
                border-left: 18px solid #01e0dc;
            }
            .button-red {
                background-color: #bf5329;
                border-top: 10px solid #bf5329;
                border-right: 18px solid #bf5329;
                border-bottom: 10px solid #bf5329;
                border-left: 18px solid #bf5329;
            }
            /* Panels */
            .panel {
                margin: 0 0 21px;
            }
            .panel-content {
                background-color: #EDEFF2;
                padding: 16px;
            }
            .panel-item {
                padding: 0;
            }
            .panel-item p:last-of-type {
                margin-bottom: 0;
                padding-bottom: 0;
            }
            /* Promotions */
            .promotion {
                background-color: #FFFFFF;
                border: 2px dashed #9BA2AB;
                margin: 0;
                margin-bottom: 25px;
                margin-top: 25px;
                padding: 24px;
                width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 100%;
            }
            .promotion h1 {
                text-align: center;
            }
            .promotion p {
                font-size: 15px;
                text-align: center;
            }
            .text-right{
                text-align: right;
            }
            .text-left{
                text-align: left;
            }
            .text-center{
                text-align: center;
            }
            .gradient-gray{
                background: #f8ffff;
                background: linear-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6);
                background: -webkit-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6); 
                background: -webkit-linear-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6);
                background: -moz-linear-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6);
                background: -ms-linear-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6);
                background: -o-linear-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6);
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e5e6e6', endColorstr='#f8ffff',GradientType=1 );
            }
            font-40{
                font-size: 40px;
            }
            .marg-top-10{
                margin-top: 20px;
            }
            .mag_left{
                margin-left: 20px;
            }
            @media only screen and (max-width: 600px) {
                .inner-body {
                    width: 100% !important;
                }
                .footer {
                    width: 100% !important;
                    background: #1d1d1d;
                }
            }
            @media only screen and (max-width: 500px) {
                .button {
                    width: 100% !important;
                }
                h1 {
                    font-size: 38px;
                }
                h2 {
                    font-size: 26px;
                }
                h3 {
                    font-size: 17px;
                }
            }
            @media only screen and (max-width: 400px) {
                .icon-top{
                    margin-top: 24px;
                }
            }
            @media only screen and (max-width: 390px) {
                .img-icon{
                    max-width: 95px;
                }
                h3 {
                    font-size: 16px;
                }
            }
        </style>
        <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <table class="content" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="header" style="padding: 25px 0;text-align: center;color:#fff;background:#01e0dc;">
                                <a href="{{$site_url}}" ><img src="{{ asset('images/email/logo_white.png') }}"/></a>
                            </td>
                        </tr>
                        <!-- Email first Body -->
                        <tr>
                            <td class="body gradient-gray" width="100%" cellpadding="0" cellspacing="0" style="background: #f8ffff;background: linear-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6);background: -webkit-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6); background: -webkit-linear-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6);background: -moz-linear-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6);background: -ms-linear-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6);background: -o-linear-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e5e6e6', endColorstr='#f8ffff',GradientType=1 );">
                                <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
                                    <!-- Body content -->
                                    <tr>
                                        <td class="content-cell" style="padding:35px 35px 20px 35px">
                                            <h1 style="color: #2F3133; font-size: 40px;  text-align: center;">مرحبا بك معنا فى النادى الاهلى</h2>
                                            <table class="subcopy" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <p style="font-size: 24px;color: #74787E;line-height: 2em;text-align: center;margin-bottom: 2px;">
                                                            master_ahly
                                                        </p>
                                                        <h3 style="text-align: center;font-size: 24px;color: #74787E;">master_ahly</h3>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- Email second Body -->
                        <tr>
                            <td class="body  ground-syan" width="100%" cellpadding="0" cellspacing="0" style="background:#01e0dc;" >   
                                <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
                                    <!-- Body content -->
                                    <tr>
                                        <td class="content-cell" style="padding:15px 35px 35px 35px">
                                            <table class="subcopy subcopy-top subcopy-border" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <img src="{{$images_course }}" style="margin-right: 7px;display: inline-block;width:200px;height:200px;border-radius: 50%;max-width: 100%;" />
                                                    </td>
                                                    <td>
                                                        <table class="subcopy" align="center" width="100%" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td>
                                                                    <h3 style="color:#fff; font-size:16px; text-align: left;">Course Name : &nbsp; {{$course}}</h3>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h3 style="color:#fff; font-size:16px;text-align: left;">Price : &nbsp;  @if($price <= 0.00 ||$price =='0.00') <span style="color:green;"> Free </span> @else {{$price}} &nbsp; KD @endif </h3>
                                                                </td>
                                                            </tr>
                                                            @if($discount > 0.00 ||$discount!='0.00')
                                                            <tr>
                                                                <td>
                                                                    <h3 style="color:#fff; font-size:16px;text-align: left;">Discount : &nbsp; {{$discount}} &nbsp; %</h3>
                                                                </td>
                                                            </tr>
                                                            @endif
                                                            <tr>
                                                                <td>
                                                                    <h3 style="color:#fff; font-size:16px;text-align: left;">Instructor : &nbsp; {{$instructor}}</h3>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- Email seconds Body -->
                        <tr>
                            <td class="body gradient-gray" width="100%" cellpadding="0" cellspacing="0" style="background: #f8ffff;background: linear-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6);background: -webkit-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6); background: -webkit-linear-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6);background: -moz-linear-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6);background: -ms-linear-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6);background: -o-linear-gradient(to bottom, #e5e6e6 , #f8ffff,#f8ffff,#e5e6e6);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#e5e6e6', endColorstr='#f8ffff',GradientType=1 );">
                                <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
                                    <!-- Body content -->
                                    <tr>
                                        <td class="content-cell" style="padding:35px 35px 20px 35px">
                                            <table class="subcopy" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <p style="font-size: 24px;color: #74787E;line-height: 2em;text-align: center;margin-bottom: 2px;">
                                                            شكرا لك على انضمامك ونتمنى لك الاستمتاع في التعلم معنا
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table class="subcopy" align="center" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <a href="{{$site_course}}" class="button button-syan" target="_blank" style="text-align: center;line-height: 32px;background-color: #01e0dc;border-radius:16px;-webkit-text-size-adjust: none;text-decoration: none;display:block;color: #FFF; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.31);">
                                                            <p style="font-size: 24px;color: #fff;line-height: 2.5em;text-align: center;padding: 0px 25px"> شـاهـد  الـدورة</p>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!--footer-->
                        <tr>
                            <td style="color:#fff;background:#1d1d1d;">
                                <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="content-cell" align="left" style="padding: 35px;color:#fff;background:#1d1d1d;">
                                            <a href="{{$site_url}}" ><img style="margin-bottom: 20px;" class="marg-top-10" src="{{ asset('images/email/logo_white.png') }}" alt=""/></a>
                                            <table class="subcopy" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td><a  style="margin-bottom: 20px;"><img src="{{ asset('images/email/phone.png') }}" />&nbsp;&nbsp;&nbsp;{{$phone}}</a></td>
                                                </tr>
                                                <tr>
                                                    <td><a  style="margin-bottom: 20px;" href="mailto:{{$site_email }}" target="_blank"><img src="{{ asset('images/email/email.png') }}" />&nbsp;&nbsp;&nbsp;{{$site_email}}</a></td>
                                                </tr>
                                            </table>
                                        </td>
                                        @if($facebook !='' || $twitter !='' || $google !='' || $linkedin !='')
                                        <td class="content-cell" align="right" style="padding: 35px;color:#fff;background:#1d1d1d;">
                                            <h3>Social Media</h3>
                                            <table class="subcopy text-right" align="right" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <div style="float:right;">
                                                            @if(!empty($facebook))
                                                            <a href="{{$facebook}}" target="_blank"><img src="{{ asset('images/email/facebook.png') }}" /></a>
                                                            @endif
                                                            @if(!empty($twitter))
                                                            <a href="{{$twitter}}" target="_blank"><img src="{{ asset('images/email/twitter.png') }}" /></a>
                                                            @endif
                                                            @if(!empty($google))
                                                            <a href="{{$google}}" target="_blank"><img src="{{ asset('images/email/gplus.png') }}" /></a>
                                                            @endif
                                                            @if(!empty($linkedin))
                                                            <a href="{{$linkedin}}" target="_blank"><img src="{{ asset('images/email/linkedin.png') }}" /></a>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        @endif
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="color:#fff;background:#1d1d1d;">
                                <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="content-cell" align="center" style="padding: 35px;color:#fff;background:#1d1d1d;">
                                            &copy; {{ date('Y') }} <a href="{{$site_url}}" >Baims</a>. All rights reserved.
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>
