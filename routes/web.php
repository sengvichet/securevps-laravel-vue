<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//pages
Route::get('/', 'PagesController@index');
Route::get('aboutus', 'PagesController@aboutus');
Route::get('contact', 'PagesController@contact');
Route::get('faq', 'PagesController@faq');
Route::get('vps', 'PagesController@vps');
Route::get('shared', 'PagesController@shared');
Route::get('colocation', 'PagesController@servers');
Route::get('terms', 'PagesController@terms');
Route::get('domains', 'PagesController@domains');
Route::get('blog', 'PagesController@blog');
Route::get('support', 'PagesController@support');
Route::get('order', 'PagesController@order');
Route::get('cart', 'PagesController@cart');
Route::get('wizard', 'PagesController@wizard');
Route::get('cookie-policy', 'PagesController@cookiePolicy');
Route::get('get-session-result', 'PagesController@getSessionResult');
Route::get('amazongooglecloud', 'PagesController@amazonGoogleCloud');
Route::get('ssl', 'PagesController@ssl');
Route::get('ips', 'PagesController@ips');
Route::get('controlpanel', 'PagesController@controlPanel');
Route::get('policy', 'PagesController@policy');


// Route::get('mytest', '\App\Libraries\Payment\CartPayment@deleteCartData');


Route::group(['namespace' => 'Auth'], function () {
    Route::post('/close-cookie-info', 'LoginController@cookiePolicyStatus');
    Route::get('/close-cookie-info-for-user', 'LoginController@closeCookieInfoForUser');
    Route::get('/call-to-get-cookie-info', 'LoginController@callToUserCookiePolicyStatus');

    Route::group(['middleware' => 'guest'], function () {

        Route::group(['prefix' => 'register'], function () {

            Route::get('/', 'RegisterController@showRegistrationForm');
            Route::post('/', 'RegisterController@register');
            Route::get('/done', 'RegisterController@firstStepDone');
            Route::get('confirm/{token}', 'RegisterController@confirmEmail');
            Route::get('phone', 'RegisterController@phone');
            Route::post('phone', 'RegisterController@joinUs');
            Route::get('smscode', 'RegisterController@smsCode');
            Route::post('smscode', 'RegisterController@validateJoinUsSMSAuthCode');
            Route::get('password', 'RegisterController@password');
            Route::post('setPassword', 'RegisterController@setPassword');
        });

        Route::get('/accountlist', 'LoginController@accountList');
        Route::post('/loginwithaccountname', 'LoginController@loginWithAccountName');
        Route::get('/login', 'LoginController@showLoginForm');
        Route::post('/login', 'LoginController@login');

        Route::post('sendMeSmsCodeForLogin', 'LoginController@sendMeSmsCodeForLogin');
        Route::post('validateMySmsCodeForLogin', 'LoginController@validateMySmsCodeForLogin');
        Route::get('login/accountlistbyemail/{token}', 'LoginController@accountListForEmail');
    });

    Route::group(['middleware' => 'auth'], function () {

        Route::get('/logout', 'LoginController@logout');
    });





    Route::group(['prefix' => 'password'], function () {

        Route::get('change', 'ChangePasswordController@showPasswordForm');
        Route::post('change', 'ChangePasswordController@store');
        Route::get('reset', 'ResetPasswordController@showPasswordResetForm');
        Route::post('resetbyusername', 'ResetPasswordController@ResetByUsername');
        Route::get('smsoremail', 'ResetPasswordController@showSmsOrEmailForm');
        Route::get('firstconfirm/{token}', 'ResetPasswordController@firstConfirm');
        Route::get('confirm/{token}', 'ResetPasswordController@confirm');
        Route::post('setnewpass', 'ResetPasswordController@setNewPass');
        Route::post('storenewpass', 'ResetPasswordController@storeNewPass');
        Route::post('resetpasswordmethod', 'ResetPasswordController@ResetPasswordMethod');
        Route::get('resetbyemailb', 'ResetPasswordController@showPasswordEmailResetForm');
        Route::post('sendresetbyemailb', 'ResetPasswordController@ResetPasswordByEmailb');
        Route::post('accountslistresetbyemail', 'ResetPasswordController@ResetPasswordByEmailAccountsList');
        Route::get('resetbysmsb', 'ResetPasswordController@showPasswordSmsResetForm');
        Route::get('resetbysms', 'ResetPasswordController@showCheckSmsCodeForm');
        Route::post('resetbysms', 'ResetPasswordController@ResetPasswordBySms');
        Route::post('checksmscode', 'ResetPasswordController@checkSmsCode');
    });
});





Route::group(['prefix' => 'user', 'middleware' => 'auth', 'namespace' => 'User'], function () {

    Route::get('domainSpaces', 'UserController@domainSpaces');
    Route::get('invoices', 'UserController@invoices');
    Route::get('receipts', 'UserController@receipts');
    Route::get('credit-card', 'UserController@creditCard');
    Route::get('profile', 'ProfileController@edit');
    Route::post('profile', 'ProfileController@update');
});





Route::group(['prefix' => 'payment', 'middleware' => 'auth'], function () {

    Route::get('/', 'PaymentController@index');
    Route::get('pay', 'PaymentController@pay');
    Route::get('good', 'PaymentController@goodUrl');
    Route::post('good', 'PaymentController@goodUrl');
    Route::post('error', 'PaymentController@errorUrl');
});





Route::group(['prefix' => 'admin'], function () {

    Route::group(['middleware' => 'guest', 'namespace' => 'Auth'], function () {

        Route::get('login', 'AdminLoginController@showLogin');
        Route::post('login', 'AdminLoginController@postLogin');
        Route::post('sendMeSmsCodeForAdminLogin', 'AdminLoginController@sendMeSmsCodeForAdminLogin');
    });

    Route::group(['middleware' => 'admin', 'namespace' => 'Auth'], function () {

        Route::get('logout', 'AdminLoginController@logout');
    });

    Route::group(['middleware' => 'admin', 'namespace' => 'Admin'], function () {

        Route::get('items', 'AdminController@items');
        Route::get('users', 'AdminController@users');
        Route::get('local-users', 'AdminController@localUsers');
        Route::get('domain-spaces', 'AdminController@domainSpaces');
        Route::get('orders', 'AdminController@orders');
        Route::get('sessions', 'AdminController@sessions');
    });
});





Route::group(['prefix' => 'api', 'namespace' => 'API'], function () {

    Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'namespace' => 'Admin'], function () {

        Route::get('items', 'ItemsController@index');
        Route::get('items/import', 'ItemsController@import');
        Route::get('items/destroy', 'ItemsController@destroy');
        Route::get('items/destroy-all', 'ItemsController@destroyAll');
        Route::get('items/{id}/enable', 'ItemsController@enable');
        Route::get('local-users', 'LocalUsersController@index');
        Route::post('trancate-local-users', 'LocalUsersController@trancate');
        Route::post('delete-local-user', 'LocalUsersController@delete');
        Route::get('domain-spaces', 'DomainSpacesController@index');
        Route::get('orders', 'OrdersController@index');
        Route::get('sessions', 'SessionsController@index');
        Route::post('destroy-sessions', 'SessionsController@trancate');
        Route::post('delete-session', 'SessionsController@delete');
        Route::get('users', 'UsersController@index');
        Route::post('loginAsUser', 'UsersController@loginAsUser');
    });

    Route::group(['middleware' => 'auth', 'prefix' => 'payment'], function () {

        Route::get('/', 'PaymentController@getData');
        Route::post('checkdomainavaliable', 'PaymentController@checkDomainAvaliable');
        Route::post('change-save-token-status', 'PaymentController@changeSaveTokenStatus');
        Route::post('summerize', 'PaymentController@setSummerize');
    });

    Route::group(['prefix' => 'cart'], function () {

        Route::get('/', 'CartController@index');
        Route::get('/add/{id}', 'CartController@store');
        Route::delete('/', 'CartController@destroy');
        Route::get('wizard', 'WizardController@index');
        Route::get('vps_addons', 'WizardController@getVPSAddons');
        Route::get('shared_addons', 'WizardController@getSharedAddons');
        Route::post('addons', 'WizardController@store');
        Route::post('isUserConnected', 'CartController@isUserConnected');
    });

    Route::group(['middleware' => 'auth', 'namespace' => 'User'], function () {

        Route::get('getDomainSpaces', 'DomainSpacesController@index');
        Route::get('getOrderData/{docEntry}', 'DomainSpacesController@orderData');

        Route::post('getDomainInvoicesAndReceipts', 'DomainSpacesController@getDomainInvoicesAndReceipts');
        Route::get('createPdf/{docEntry}/{thedate}/{doctype}', 'DomainSpacesController@createPdf');
        Route::get('download/{filename}', 'DomainSpacesController@download');

        Route::get('getAllClientInvoices', 'DomainSpacesController@getAllClientInvoices');
        Route::get('getAllClientReceipts', 'DomainSpacesController@getAllClientReceipts');
        Route::get('get-invoice-years', 'DomainSpacesController@GetInvoiceYears');
        Route::post('create-invoice', 'DomainSpacesController@CreateInvoiceYears');

        Route::get('check-parent-package', 'DomainSpacesController@checkAddonParentPackageDate');
        Route::get('check-active-addon', 'DomainSpacesController@checkActiveAddonOnPackage');

    });

    Route::group(['prefix' => 'upgrade', 'namespace' => 'User'], function () {

        Route::get('packeges/{currentId}/{upgradeType}/{res?}', 'UpgradeController@getPackeges');
        Route::post('summerize', 'UpgradeController@setSummerize');
        Route::post('getNewAddons', 'UpgradeController@getNewAddons');
        Route::get('get-all-packages/{type}/{os}/{description}', 'UpgradeController@getAllPackages');
    });

    Route::group(['middleware' => 'auth', 'prefix' => 'credit-cards'], function () {

        Route::get('/', 'CreditCardController@index');
        Route::delete('/', 'CreditCardController@destroy');
        Route::post('mark-as-default', 'CreditCardController@markAsDefault');
    });
});

//Route::group(['middleware' => 'auth:api', 'prefix' => 'api', 'namespace' => 'User'], function () {
//    Route::get('credit-cards', 'UserController@removeCard');
//});
