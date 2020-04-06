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
                font-family: 'JannaLTBold';
                src: url("{{asset('css/site/fonts/JannaLT-Bold.ttf')}}");
                font-display: fallback;
            }
            @font-face {
                font-family: 'JannaLT';
                src: url("{{asset('css/site/fonts/JannaLT-Regular.ttf')}}");
                font-display: fallback;
            }
            body, body *:not(html):not(style):not(br):not(tr):not(code) {
                font-family: JannaLT;
                box-sizing: border-box;
                /*direction: rtl;*/
            }
            body {
                color: #ffffff;/*#74787E;*/
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
            /* Body */
            .body {
                background-color: #ffffff;
                margin: 0;
                padding: 0;
                width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 100%;
            }
            .hr_line_top {
                border-top: 1px solid #D8D8D8; /*EDEFF2*/
            }
            .hr_line_down {
                /*border-bottom: 1px solid #D8D8D8;*/
            }
            .inner-body {
                background-color: #ffffff;
                margin: 0 auto;
                padding: 0;
                width: 570px;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 570px;
            }
            .wrapper {
                background-color: #ffffff; 
                margin: 0;
                padding: 0;
                width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 100%;
            }
            a {cursor: pointer;}
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
            /* Header */
            .header {
                padding: 25px 0;text-align: right;
            }
            .header a {
                color: #ffffff;/*#01e0dc;*/
                font-size: 19px;font-weight: bold;text-decoration: none;text-shadow: 0 1px 0 white;float: right;
            }
            h1{
                font-family: JannaLT;
                direction: rtl;font-weight: bold;font-size: 24px;color: #000000;letter-spacing: 0;text-align: right;
            }
            .btn-syan{
                font-family: JannaLT;font-size: 16px; font-weight: bold;background: #00CECD;border-radius: 6px;text-decoration: none;text-align: center;display:inline-block;color: #000; padding: 10px 40px;
                font-style: normal;
                font-stretch: normal;
                line-height: normal;
                letter-spacing: normal;
                -webkit-text-size-adjust: none;
                float: right;
            }
            .cart-name{
                background: rgba(10,138,255,0.10);margin-bottom: 40px;color: #4A90E2;text-align: right;padding: 10px 50px;
            }
            .back-gray,.back-gray .subcopy{
                background: #F8F8F8;
            }
            .ft-img{
                letter-spacing: 0;
                margin-bottom: 10px;float: right; text-align: right;color: #4A4A4A;font-size: 36px;
            }
            .text-img,.p-main{
                font-style: normal;font-stretch: normal;line-height: normal;letter-spacing: normal;
            }
            .p-main{
                font-weight: normal;text-align: justify;
            }
            .p-footer{
                font-stretch: normal;
                line-height: normal;
                letter-spacing: normal;
                font-style: normal;font-family: JannaLT;font-size: 10px;color: #8593A6;line-height: 16px;
                /*direction: rtl;*/
            }
            .pad-tb50{
                padding-top: 40px; padding-bottom: 50px;
            }
            .pad-tb70{
                padding-top: 70px;padding-bottom: 70px;
            }
            @media only screen and (max-width: 600px) {
                .inner-body {
                    width: 100% !important;
                }

                .footer {
                    width: 100% !important;
                }
            }

            @media only screen and (max-width: 500px) {
                .button,.btn {
                    width: 100% !important;
                }
                .mobile-right{float:right;text-align:right;}
            }
        </style>
        <table class="wrapper" width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td align="center">
                    <table class="content" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="header" style="padding: 25px 0;">
                                <table class="inner-body mobile-right" align="center" width="570" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="content-cell">
                                            <table class="subcopy" align="right" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td style="text-align: right;float: right;">
                                                        <a href="{{ route('home') }}" style="color: #01e0dc;font-size: 19px;font-weight: bold;text-decoration: none;text-shadow: 0 1px 0 white;"><img src="{{ asset('images/logo/logo.png') }}"/></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
