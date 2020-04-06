<ul class="social-icon">
    <li><a class="tran3s" href="https://www.facebook.com/share.php?u={{$share_link}}&title={{$title}}&desc={{str_limit(strip_tags($share_description), $limit = 80, $end = '...')}}&amp;picture=http://alahliclub.sakb.net{{$share_image}}" onclick="window.open(this.href, 'facebook-share-dialog',
'left=20,top=20,width=400,height=400,toolbar=1,resizable=0'); return false;" ><i class="fa fa-facebook" aria-hidden="true"></i></a></li>

<li><a class="tran3s" href="whatsapp://send?text={{$share_link}}&title={{$title}}&desc={{str_limit(strip_tags($share_description), $limit = 80, $end = '...')}}&amp;picture=http://alahliclub.sakb.net{{$share_image}}" imageanchor="1"><i class="fa fa-whatsapp"></i></a></li>
    
<li><a class="tran3s" href="https://twitter.com/share?url={{$share_link}}&title={{$title}}&desc={{str_limit(strip_tags($share_description), $limit = 80, $end = '...')}}&amp;picture=http://alahliclub.sakb.net{{$share_image}}" onclick="window.open(this.href, 'twitter-share-dialog',
'left=20,top=20,width=400,height=400,toolbar=1,resizable=0'); return false;" ><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
    <!--<li><a href="#" class="tran3s"><i class="fa fa-skype" aria-hidden="true"></i></a></li>-->
   
    <li><a class="tran3s" style="font-weight:bold;" href="https://plus.google.com/share?url={{$share_link}}&title={{$title}}&desc={{str_limit(strip_tags($share_description), $limit = 80, $end = '...')}}&amp;picture=http://alahliclub.sakb.net{{$share_image}}" onclick="window.open(this.href, 'gplus-share-dialog',
'left=20,top=20,width=400,height=400,toolbar=1,resizable=0'); return false;" ><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
  
    <li><a class="tran3s" style="font-weight:bold;" href="http://www.linkedin.com/shareArticle?mini=true&url={{$share_link}}&title={{$title}}&desc={{str_limit(strip_tags($share_description), $limit = 80, $end = '...')}}&amp;picture=http://alahliclub.sakb.net{{$share_image}}" onclick="window.open(this.href, 'linkedin-share-dialog',
'left=20,top=20,width=400,height=400,toolbar=1,resizable=0'); return false;" ><i class="fa fa-linkedin"></i></a></li>
   
    <li><a class="tran3s pinterest" href="https://pinterest.com/share" 
   onclick="window.open('https://pinterest.com/share?url=' + escape(window.location.href) + '&text=' + document.title, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');
                return false;" title="pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
   
</ul>