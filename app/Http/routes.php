<?php
Route::group(['middleware' => 'web'], function () {

    Route::group(['middleware' => 'frontendorbackend'], function () {

    //Frontend
    // Route::get('/', 'Frontend\HomeController@index');
    //redirect to backend login directly
    Route::get('/', array('as'=>'backend/','uses'=>'Auth\AuthController@showFirstLogin'));

    //Backend
    Route::group(['prefix' => 'backend'], function () {

    // Route::get('/', 'Auth\AuthController@showLogin');
    Route::get('/', 'Auth\AuthController@showFirstLogin');
    Route::post('first_login','Auth\AuthController@doFirstLogin');
    Route::get('login', array('as'=>'backend/login','uses'=>'Auth\AuthController@showLogin'));
    Route::post('login', array('as'=>'backend/login','uses'=>'Auth\AuthController@doLogin'));
    Route::get('logout', array('as'=>'backend/logout','uses'=>'Auth\AuthController@doLogout'));
    Route::get('dashboard', array('as'=>'backend/dashboard','uses'=>'Core\DashboardController@dashboard'));
    Route::get('/errors/{errorId}', array('as'=>'backend//errors/{errorId}','uses'=>'Core\ErrorController@index'));
    Route::get('/unauthorize', array('as'=>'backend/unauthorize','uses'=>'Core\ErrorController@unauthorize'));

    // Password Reset Routes...
    Route::get('password/reset/{token?}', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@showResetForm']);
    Route::post('password/email', ['as' => 'auth.password.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
    Route::post('password/reset', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@reset']);
    });

    Route::group(['middleware' => 'right'], function () {


        //Backend
        Route::group(['prefix' => 'backend'], function () {
            // Site Configuration
            Route::get('config', array('as'=>'backend/config','uses'=>'Core\ConfigController@edit'));
            Route::post('config', array('as'=>'backend/config','uses'=>'Core\ConfigController@update'));

            //User
            Route::get('user', array('as'=>'backend/user','uses'=>'Core\UserController@index'));
            Route::get('user/create', array('as'=>'backend/user/create','uses'=>'Core\UserController@create'));
            Route::post('user/store', array('as'=>'backend/user/store','uses'=>'Core\UserController@store'));
            Route::get('user/edit/{id}',  array('as'=>'backend/user/edit','uses'=>'Core\UserController@edit'));
            Route::post('user/update', array('as'=>'backend/user/update','uses'=>'Core\UserController@update'));
            Route::post('user/destroy', array('as'=>'backend/user/destroy','uses'=>'Core\UserController@destroy'));
            Route::get('user/profile/{id}', array('as'=>'backend/user/profile','uses'=>'Core\UserController@profile'));
            Route::get('userAuth', array('as'=>'backend/userAuth','uses'=>'Core\UserController@getAuthUser'));

            //Role
            Route::get('role', array('as'=>'backend/role','uses'=>'Core\RoleController@index'));
            Route::get('role/create',  array('as'=>'backend/role/create','uses'=>'Core\RoleController@create'));
            Route::post('role/store',  array('as'=>'backend/role/store','uses'=>'Core\RoleController@store'));
            Route::get('role/edit/{id}',  array('as'=>'backend/role/edit','uses'=>'Core\RoleController@edit'));
            Route::post('role/update',  array('as'=>'backend/role/update','uses'=>'Core\RoleController@update'));
            Route::post('role/destroy',  array('as'=>'backend/role/destroy','uses'=>'Core\RoleController@destroy'));
            Route::get('rolePermission/{roleId}', array('as'=>'backend/rolePermission','uses'=>'Core\RoleController@rolePermission'));
            Route::post('rolePermissionAssign/{id}',   array('as'=>'backend/rolePermissionAssign','uses'=>'Core\RoleController@rolePermissionAssign'));

            //Permission
            Route::get('permission', array('as'=>'backend/permission','uses'=>'Core\PermissionController@index'));
            Route::get('permission/create', array('as'=>'backend/permission/create','uses'=>'Core\PermissionController@create'));
            Route::post('permission/store', array('as'=>'backend/permission/store','uses'=>'Core\PermissionController@store'));
            Route::get('permission/edit/{id}', array('as'=>'backend/permission/edit','uses'=>'Core\PermissionController@edit'));
            Route::post('permission/update', array('as'=>'backend/permission/update','uses'=>'Core\PermissionController@update'));
            Route::post('permission/destroy', array('as'=>'backend/permission/destroy','uses'=>'Core\PermissionController@destroy'));

            //Reports
            //Invoice Report
            Route::get('invoice_report', array('as'=>'backend/invoice_report','uses'=>'Backend\InvoiceReportController@index'));
            Route::get('invoice_report/search/{from_date?}/{to_date?}/{status?}', array('as'=>'backend/invoice_report/search','uses'=>'Backend\InvoiceReportController@search'));
            Route::get('invoice_report/detail/{id}', array('as'=>'backend/invoice_report/detail','uses'=>'Backend\InvoiceReportController@invoiceDetail'));
            Route::post('invoice_report/deliver_invoice', array('as'=>'backend/invoice_report/deliver_invoice','uses'=>'Backend\InvoiceReportController@deliverInvoice'));
            Route::post('invoice_report/cancel_invoice', array('as'=>'backend/invoice_report/cancel_invoice','uses'=>'Backend\InvoiceReportController@cancelInvoice'));
            Route::post('invoice_report/partial_deliver_invoice', array('as'=>'backend/invoice_report/partial_deliver_invoice','uses'=>'Backend\InvoiceReportController@partialDeliverInvoice'));
            Route::post('invoice_report/partial_cancel_invoice', array('as'=>'backend/invoice_report/partial_cancel_invoice','uses'=>'Backend\InvoiceReportController@partialCancelInvoice'));
            Route::get('invoice_report/export_csv/{from_date?}/{to_date?}/{status?}', array('as'=>'backend/invoice_report/export_csv','uses'=>'Backend\InvoiceReportController@exportCSV'));

            //API formats
            Route::get('api_formats',array('as'=> 'backend/api_formats', 'uses'=> 'Core\ApiFormatController@index'));
        });

    });

    });

});


 Route::group(['prefix' => 'api'], function () {
        Route::post('activate', array('as'=>'activate','uses'=>'ApiController@Activate'));
        Route::post('check', array('as'=>'check','uses'=>'ApiController@check'));

        //login api
        Route::post('login_api', array('as'=>'login_api','uses'=>'Api\LoginApiController@doLogin'));

        //retailer profile download api
        Route::post('retailer_profile', array('as'=>'retailer_profile','uses'=>'Api\RetailerProfileApiController@getRetailerProfile'));

        //shop list download api
        Route::post('download_shop_list', array('as'=>'download_shop_list','uses'=>'Api\ShopListApiController@getShopList'));

        //product list download api
        Route::post('download_product_list', array('as'=>'download_product_list','uses'=>'Api\ProductApiController@getProductList'));

        //product detail download api
        Route::post('download_product_detail', array('as'=>'download_product_detail','uses'=>'Api\ProductApiController@getProductDetail'));

        //delivery date download api
        Route::post('download_delivery_date', array('as'=>'download_delivery_date','uses'=>'Api\DeliveryDateApiController@getDeliveryDate'));

        //invoice upload api
        Route::post('upload_invoice', array('as'=>'upload_invoice','uses'=>'Api\InvoiceApiController@upload'));

        //invoice list download api
        Route::post('download_invoice_list', array('as'=>'download_invoice_list','uses'=>'Api\InvoiceApiController@getInvoiceList'));

        //invoice detail download api
        Route::post('download_invoice_detail', array('as'=>'download_invoice_detail','uses'=>'Api\InvoiceApiController@getInvoiceDetail'));
    });
