<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/generate/menu', 'PagesController@generateMenu');

Route::get('/generate', function () {
    try {
        $exitCode = Artisan::call('key:generate');
    } catch (Exception $e) {
        echo $e->getMessage();
    }
});
Route::get('/connection', function () {
    try {
        $dbconnect = DB::connection()->getPDO();
        $dbname = DB::connection()->getDatabaseName();
        echo "Connected successfully to the database. Database name is :" . $dbname;
    } catch (Exception $e) {
        echo $e->getMessage();
    }
});
// Remove route cache
Route::get('/clear-route-cache', function () {
    $exitCode = Artisan::call('route:cache');
    return 'All routes cache has just been removed';
});
Route::get('/cache-clear', function () {
    Artisan::call('cache:clear');
    return "cache clear All";
    //dd("cache clear All");
});

Route::get('/config-clear', function () {
    Artisan::call('config:clear');
    return "config clear All";
    //dd("cache clear All");
});

Route::get('/storage', function () {
    Artisan::call('storage:link');
    return "storage link";
    //dd("cache clear All");
});

Route::get('/schedule', function () {
    Artisan::call('schedule:run');
    return "storage link";
    //dd("cache clear All");
});

Route::get('/optimize', function () {
    Artisan::call('optimize');
    return "optimize";
    //dd("cache clear All");
});


Route::get('/send-mail', 'MailController@resetPassword');

Route::group([ 'middleware' => 'auth'], function () {
    Route::get('/update-password', 'PagesController@updatePassword');
    Route::post('/submit-updatepass', 'System\UsersController@submitUpdatepassword')->name('submit-updatepass');
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'DashboardController@index')->name('home');
   
    Route::get('/menu', 'PagesController@menu')->name('menu');
    Route::get('/permission-denied', 'PagesController@permissionDenied');
    Route::get('/profile', 'PagesController@profile')->name('profile');
    Route::post('update-profile', 'System\UsersController@updateProfile')->name('update-profile');
   
});

// orders
Route::group(['prefix' => 'orders', 'middleware' => 'auth'], function () {
    Route::get('/inprogres', 'OrderController@inprogres')->name('orders.inprogres');
    Route::get('/selesai', 'OrderController@selesai')->name('orders.selesai');
    Route::get('list', 'OrderController@getData')->name('orders.data');
    Route::post('submit', 'OrderController@storeOrUpdate')->name('orders.submit');
    Route::post('submit/tahapanproses', 'OrderController@tahapanProses')->name('orders.tahapanprosess');
    Route::post('show', 'OrderController@show')->name('orders.show');
    Route::delete('delete', 'OrderController@destroy')->name('orders.delete');
    Route::post('history', 'OrderController@history')->name('orders.history');
    Route::get('export', 'OrderController@exportOrder')->name('orders.export');
    Route::get('print-order','OrderController@printOrder')->name('orders.print-riwayat');
    
});

// unit pembangkit
Route::group(['prefix' => 'piutangs', 'middleware' => 'auth'], function () {
   
    Route::get('/', 'PiutangController@index')->name('piutang.index');
    Route::get('list', 'PiutangController@getData')->name('piutang.data');
    Route::post('submit', 'PiutangController@submit')->name('piutang.submit');
    Route::post('show', 'PiutangController@show')->name('piutang.show');
    Route::delete('delete', 'PiutangController@destroy')->name('piutang.delete');
    Route::get('detail', 'PiutangController@detail')->name('piutang.detail');
    Route::get('detail/list', 'PiutangController@detailList')->name('piutang.detail_list');
    Route::post('detail/submit', 'PiutangController@submitDetail')->name('piutang.submit_detail');
    Route::post('detail/show', 'PiutangController@showDetail')->name('piutang.show_detail');
    Route::delete('detail/delete', 'PiutangController@destroyDetail')->name('piutang.delete_detail');
    
});

Route::group(['prefix' => 'system', 'middleware' => 'auth'], function () {

    //user
    Route::get('/users', 'System\UsersController@index');
    Route::get('/users/ajax-data', 'System\UsersController@ajaxData');
    Route::post('/users/submit', 'System\UsersController@submit');
    Route::post('/users/show', 'System\UsersController@show');
    Route::delete('/users/delete', 'System\UsersController@destroy');
    //role
    Route::get('/role', 'System\RolesController@index');
    Route::get('/role/ajax-data', 'System\RolesController@ajaxData');
    Route::post('/role/submit', 'System\RolesController@submit');
    Route::post('/role/create', 'System\RolesController@store');
    Route::post('/role/show', 'System\RolesController@show');
    Route::delete('/role/delete', 'System\RolesController@destroy');
    Route::get('/role/role-access', 'System\RolesController@roleAccess')->name('generate-menu-access');

    //menu
    Route::get('/menu', 'System\MenuController@index');
    Route::get('/menu/ajax-data', 'System\MenuController@ajaxData');
    Route::post('/menu/submit', 'System\MenuController@submit');
    Route::post('/menu/show', 'System\MenuController@show');
    Route::delete('/menu/delete', 'System\MenuController@destroy');
    Route::get('/menu/action', 'System\MenuController@menuAction')->name('generate-menu-action');

});

Route::group(['prefix' => 'autocomplete', 'middleware' => 'auth'], function () {

    //user
    Route::get('/key', 'AutocompleteController@datalist');
    Route::get('/keterangan', 'AutocompleteController@datalistKet');
    Route::get('/vendor', 'AutocompleteController@datalistVendor');
});

// Quick search dummy route to display html elements in search dropdown (header search)
Route::get('/quick-search', 'PagesController@quickSearch')->name('quick-search');













require __DIR__ . '/auth.php';
