@include('emails.header')
    <!-- Email first Body -->
   <tr>
       <td class="body hr_line_top pad-tb50" style="padding-top: 20px; padding-bottom: 50px;border-top: 1px solid #D8D8D8;" width="100%" cellpadding="0" cellspacing="0">
           <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0">
               <!-- Body content -->
               <tr>
                   <td class="content-cell">
                       <h1 style="direction: rtl;font-weight: bold;font-size: 22px;color: #000000;letter-spacing: 0;text-align: right;">مرحبا بك معنا فى سكب المتطورة 👋</h1>
                       <table class="subcopy" align="center" width="100%" cellpadding="0" cellspacing="0">
                           <tr>
                               <td>
                                   <p class="p-main" style="direction: rtl;font-weight: normal;text-align: justify;font-family: JannaLT;font-size: 16px;color: #4A4A4A;letter-spacing: 0;text-align: right;">{!!$message_share!!}</p>
                                   <a href="{{$site_url}}" class="btn btn-syan" target="_blank" style="float: right;font-family: JannaLT;font-size: 16px; font-weight: bold;background: #00CECD;border-radius: 6px;text-decoration: none;text-align: center;display:inline-block;color: #000; padding: 10px 40px;" > سكب المتطورة</a>
                               </td>
                           </tr>
                       </table>
                   </td>
               </tr>
           </table>
       </td>
   </tr>             
@include('emails.footer')