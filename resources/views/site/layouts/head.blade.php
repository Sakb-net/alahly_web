<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<!-- Meta -->
<meta name="description" content="{{ $description }} " />
<meta name="keywords" content="{{ $keywords }}" />
<meta name="reply-to" content="{{ $email }}">
<meta name="author" content="ALAHLIFC">
<meta name="designer" content="ALAHLIFC">
<meta name="owner" content="{{ config('app.name', 'ALAHLIFC') }}">
<meta name="revisit-after" content="7 days">

<!-- image -->
<link href="{{ $share_image  }}" />
<meta name="medium" content="image" />
<meta property="og:type" content="instapp:photo" />

<!-- for Facebook, Pinterest, LinkedIn, Google+ --> 
<meta property="og:image" content="{{ $share_image  }}">
<meta property="og:url" content="{{ Request::url() }}">
<meta property="og:title" content="{{ $title  }}">
<meta property="og:site_name" content="{{ config('app.name', 'ALAHLIFC') }}">
<meta property="fb:app_id" content="485726318457824">
<meta property="og:image:width" content="476"/>
<meta property="og:image:height" content="249"/>

<!-- for Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="{{ config('app.name', 'ALAHLIFC') }}">
<meta name="twitter:title" content="{{ $title  }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $share_image }}">  

<!-- CSRF Token -->
<meta name="_token" content="{{ csrf_token() }}"/>

<!-- Title -->
<title>{{ $title }} </title>
<!-- CSS -->
<!-- Favicon -->
<link rel="icon" type="image/png" sizes="56x56" href="{{ asset('images/fav-icon/icon.png') }}">
<!-- Main style sheet -->
<link rel="stylesheet" type="text/css" href="{{ asset('css/site/css/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/site/css/bootsnav.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/site/css/custom.css') }}">