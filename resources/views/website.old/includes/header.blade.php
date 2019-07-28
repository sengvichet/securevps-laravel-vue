<!--  HEADER -->
@yield('headercolor')

<div class="top">
  <div class="row">
  <div class="small-12 large-3 medium-3 columns">
   <div class="logo">
       <a href="{{ url('/') }}" title=""><img src="{{ url('images/logo.png') }}" alt="" title=""/></a>
   </div>
</div>

<div class="small-12 large-9 medium-9 columns">
<!--  NAVIGATION MENU AREA -->
    <nav class="desktop-menu">
     <ul class="sf-menu" id="navigation">
         @if (session('admin_signedIn'))
             <li class="admin-menu-btn"><a class="amb-btn" href="#">מנהל {{ session('admin_username') }}</a>
                 <ul>
                     <li><a href="{{ url('/admin/users') }}">משתמשים</a></li>
                     <li><a href="{{ url('/admin/domain-spaces') }}">מרחבי דומיין</a></li>
                     <li><a href="{{ url('/admin/orders') }}">הזמנות</a></li>
                     <li><a href="{{ url('/admin/items') }}">פריטים</a></li>
                     <li><a href="{{ url('/admin/local-users') }}">משתמשים בטרם SAP</a></li>
                     <li><a href="{{ url('/admin/sessions') }}">סשנים פעילים</a></li>
                     <li><a href="{{ url('/admin/logout') }}">התנתק</a></li>
                 </ul>
             </li>
         @endif
         <li><a href="/">@lang('messages.HOME')</a></li>
         <li><a href="#">@lang('messages.HOSTING')</a>
             <ul>
                <li><a href="{{ url('/shared') }}">@lang('messages.SHARED HOSTING')</a></li>
                <li><a href="{{ url('/vps') }}">@lang('messages.CLOUD VPS')</a></li>
                <li><a href="{{ url('/colocation') }}">@lang('messages.DEDICATED SERVERS')</a></li>
                <li><a href="{{ url('/amazongooglecloud') }}"><span>Amazon/Google Cloud VPS</span></a></li>
             </ul>
         </li>
         {{-- <li><a href="{{ url('/domains') }}">@lang('messages.DOMAINS')</a></li> --}}
         <li><a href="#">@lang('messages.PAGES')</a>
             <ul>
                <li><a href="{{ url('/aboutus') }}">@lang('messages.ABOUT US')</a></li>
                <li><a href="{{ url('/faq') }}">@lang('messages.FAQ')</a></li>
                {{--<li><a href="datacenter">DATACENTERS</a></li>--}}
                <li><a href="{{ url('/support') }}">@lang('messages.SUPPORT')</a></li>
             </ul>
          </li>
          <li><a href="{{ url('/contact') }}">@lang('messages.CONTACT')</a></li>
          @if (session('signedIn'))
              <li><a class="link-spec" href="#">שלום {{ session('username') }}</a>
                  <ul>
                      <li><a href="{{ url('/user/domainSpaces') }}">מרחבי דומיין</a></li>
                      <li><a href="{{ url('/user/invoices') }}">היסטוריית תשלומים</a></li>
                      <li><a href="{{ url('/cart') }}">עגלת קניות</a></li>
                      <li><a href="{{ url('/user/profile') }}">פרטי משתמש</a></li>
                      <li><a href="{{ url('/password/change') }}">החלפת סיסמה</a></li>
                      <li><a href="{{ url('/logout') }}">התנתק</a></li>
                  </ul>
              </li>
          @else
              <li><a class="link-spec" href="#">
                  <i class="fa fa-user" aria-hidden="true"></i>
                  כניסה לחשבון</a>
                  <ul>
                      <li><a href="{{ url('/register') }}">הרשמה למשתמש חדש</a></li>
                      <li><a href="{{ url('/login') }}">כניסה לחשבון שלי</a></li>
                      <li><a href="{{ url('/password/reset') }}">שכחתי סיסמה</a></li>
                  </ul>
              </li>
          @endif
          <li><a class="link-spec" href="{{ url('/cart') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
              עגלת קניות
             </a>
         </li>
    </ul>
  </nav>
<!--  END OF NAVIGATION MENU AREA -->

  </div>
  </div>
  </div>


<!--  MESSAGES ABOVE HEADER IMAGE -->
@yield('msgaboveheader')
<!--  END OF MESSAGES ABOVE HEADER IMAGE -->

</header>
<!--  END OF HEADER -->
