<!doctype html>
<html class="no-js" dir="rtl" lang="ar">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ url('images/icons/favicon.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.3.3/sweetalert2.css" media="screen" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.3.3/sweetalert2.js" charset="utf-8"></script>
    <link rel="stylesheet" href="{{ url('css/admin.css') }}" />
    <link rel="stylesheet" href="{{ url('css/app.css') }}" />
  </head>
 <body>

<!--  HEADER -->
@include('website.includes.header')
<!--  END OF HEADER -->


<!--  MAIN PAGE CONTENT  -->
@yield('content')
<!-- END OF MAIN PAGE CONTENT  -->


<!--  FOOTER  -->
@include('website.includes.footer-admin')
<!--  END OF FOOTER  -->

<!--  FLASH MESSAGE  -->
@include('website.includes.flash')
<!--  END OF FLASH MESSAGE  -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <script src="{{ url('js/vendor.js') }}"></script>
    <script src="{{ url('js/app.js') }}"></script>
  </body>
</html>
