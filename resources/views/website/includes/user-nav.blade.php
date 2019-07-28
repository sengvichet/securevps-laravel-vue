<div class="button-group">
    <a class="button submenu {{ setActive('/user/domainSpaces') }}" href="{{ url('/user/domainSpaces') }}"><i class="fa fa-list-ol" aria-hidden="true"></i> מרחבי דומיינים</a>
    <a class="button submenu {{ setActive('/user/invoices') }} {{ setActive('/user/receipts') }}" href="{{ url('/user/invoices') }}"><i class="fa fa-ils" aria-hidden="true"></i> היסטורית תשלומים</a>
    <a class="button submenu {{ setActive('/cart') }}" href="{{ url('/cart') }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> עגלת קניות</a>
    <a class="button submenu {{ setActive('/user/profile') }}" href="{{ url('/user/profile') }}"><i class="fa fa-user" aria-hidden="true"></i> פרטי משתמש</a>
    <a class="button submenu {{ setActive('/password/change') }}" href="{{ url('/password/change') }}"><i class="fa fa-key" aria-hidden="true"></i> החלפת סיסמה</a>
</div>

<hr>
