<!doctype html>
<html class="no-js" dir="rtl" lang="ar">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="captcha-token" content="">
    <meta http-equiv="Cache-Control" content="no-cache, no-store" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ url('images/icons/favicon.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.3.3/sweetalert2.css" media="screen" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.3.3/sweetalert2.js" charset="utf-8"></script>

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="{{ url('css/vendor.css') }}" />
    <link rel="stylesheet" href="{{ url('css/app.css') }}" />

  </head>
 <body class="{{ isset($bodyclass) ? $bodyclass : '' }}">

<!--  HEADER -->
@include('website.includes.header')
<!--  END OF HEADER -->


<!--  MAIN PAGE CONTENT  -->
@yield('content')
<!-- END OF MAIN PAGE CONTENT  -->


<!--  FOOTER  -->
{{-- 'prefix' => 'admin' payment user password register
accountlist
login --}}

@if (Request::is('user/*') ||
    Request::is('admin/*') ||
    Request::is('payment/*') ||
    Request::is('login/accountlistbyemail/*') ||
    Request::is('password/*') ||
    Request::is('register/*') ||
    Request::is('admin') ||
    Request::is('payment') ||
    Request::is('register') ||
    Request::is('accountlist') ||
    Request::is('loginwithaccountname') ||
    Request::is('cart') ||
    Request::is('wizard') ||
    Request::is('login'))
    @include('website.includes.footer-short')
@else
    @include('website.includes.footer')
@endif
<!--  END OF FOOTER  -->

<!--  FLASH MESSAGE  -->
@include('website.includes.flash')
<!--  END OF FLASH MESSAGE  -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

    <script src="{{ url('js/vendor.js') }}"></script>
    <script src="{{ url('js/app.js') }}"></script>

@if(\Session::get('getCookieResult') == 0)

    <div id="bigDiv">
        <div class="row big-div-row-style">
            @if(\Session::has('username'))
                <div class="col-md-4 close-button-style">
                    <input type="checkbox" class="checkbox checkbox-style" id="Checkbox1" value="false">
                    <span class="forever-close-text">להסתיר לצמיתות לא להראות את זה בר שוב</span>
                </div>
                <div class="col-md-1" id="Close">
                    <div class="close-button-style">סגור
                        <button type="button" class="closeButton" data-dismiss="modal">&times;</button>
                    </div>
                </div>
            @else
                    <div class="col-md-1" id="Close">
                        <div class="close-button-style">סגור
                            <button type="button" class="closeButton" data-dismiss="modal">&times;</button>
                        </div>
                    </div>
            @endif


            <div class="col-md-2" id="LearnMore">
                <div class="left">
                    <a href="{{ url('cookie-policy') }}" class="learn-more">למידע נוסף</a>
                    <img src='images/arrow_icon.png' alt="">
                </div>
            </div>


            <div class="col-md-5">
                <div>
                    <img src='images/i_icon.png' alt="">
                    <span class="span-info-style">לידיעתך:</span>
                    <span class="we-use-info-style">אנו משתמשים בעוגיות באתר זה</span>
                </div>
            </div>
        </div>
    </div>
@endif

{{--  Cookie Policy --}}
<script>
    $('body').on('click', '#Close', function(){
        $("#bigDiv").hide();

        if($("#Checkbox1").is(':checked')){
            $("#Checkbox1").attr('value', 'true');

            $.ajax({
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}", "close": "1"},
                url: '/close-cookie-info',

                success: function(data){

                }
            });
        }
    });

    $('body').on('click', '#LearnMore', function(){
        $("#bigDiv").hide();
    });

    (function() {
        $(document).ready(function() {

            $.ajax({
                type: "GET",
                data: {
                    "_token": "{{ csrf_token() }}"},
                url: '/call-to-get-cookie-info',

                success: function(data) {
                    if(data.cookieUserResult == 1){
                        $("#bigDiv").hide();
                        setSwitchState($('.switch-input'), true);
                    }else{
                        var href = window.location.href;
                        var array = href.split('/');
                        var secondSegment = array[array.length-2];
                        var lastSegment = array[array.length-1];

                        if((secondSegment == 'admin') && (lastSegment != 'login')){
                            $("#bigDiv").hide();
                            setSwitchState($('.switch-input'), true);
                        }else{
                            $("#bigDiv").show();
                            setSwitchState($('.switch-input'), false);

                        }
                    }
                },

            });


            var $switchLabel = $('.switch-label');

            $(document).on('click','.switch-input', function(){
                var isChecked = $(this).is(':checked');

                if(isChecked){
                    $("#bigDiv").hide();

                    selectedData = $switchLabel.attr('data-on');

                    $.ajax({
                        type: "POST",
                        data: {
                        "_token": "{{ csrf_token() }}", "close": "1"},
                        url: '/close-cookie-info',

                    });
                }else{
                    $("#bigDiv").show();
                    $.ajax({
                        type: "POST",
                        data: {
                        "_token": "{{ csrf_token() }}", "close": "2"},
                        url: '/close-cookie-info',

                    });
                        selectedData = $switchLabel.attr('data-off');

                }
            });

            $('body').on('click','#switchToggle span', function() {

                var isChecked = $('.switch-input').is(':checked');
                var selectedData;
                var $switchLabel = $('.switch-label');

            });

            function setSwitchState(el, flag) {
                el.attr('checked', flag);
            }

        });

    })();

</script>
{{--code Google Recaptcha--}}
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit&hl=iw"
        async defer>
</script>
<script src="https://www.recaptcha.net/recaptcha/api.js?hl=iw" async defer></script>
<script type="text/javascript">
    if($(".btn-captcha").length) {
        var verifyCallback = function(response) {
            $('meta[name=captcha-token]').attr('content', response);
            $(".btn-captcha").removeAttr('disabled');
        };
        var onloadCallback = function() {
            grecaptcha.render('captcha', {
                'sitekey' : '6Le4WJkUAAAAAHfM9uTQlokxw6sAAABajgtyx1EV',
                'callback' : verifyCallback,
            });
        };
    }
</script>
 </body>
</html>
