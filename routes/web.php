<?php

Route::get('/', function () {
    return redirect('arise-and-shine');
});

Route::match(['get', 'post'], 'register', function(){
    return view('404');
});

if(env('APP_ENV') == 'local') {
    Route::get('/try', function() {
        return view('emails.fund-raising.index', [
            'lang'        => 'en',
            'transaction' => App\Models\Transaction::find(1),
            'logo'        => '']);
    });
}

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

/*
 **********************************************************************************************
 * Frontend
 */
Route::group(['prefix' => 'events'], function () {
    Route::get('/', 'FrontendController@index');
    Route::get('/{event}', 'FrontendController@index');
});

Route::get('get-donation-number', 'FrontendController@getTotalNumber')->name('bricks.get');
Route::get('arise-and-shine', 'FrontendController@index')->name('fundraising');
Route::get('arise-and-shine/?lang=en', 'FrontendController@index')->name('fundraising');

/*
 **********************************************************************************************
 * Backend
 */
Route::group(['middleware' => ['auth', 'lang'], 'prefix' => 'admin'], function () {

    Route::get('/donation-summary/{token}', 'HomeController@showAmountInput')->name('donation.summary');
    Route::post('/donation-summary-update', 'HomeController@updateAmount')->name('donation.update');

    Route::get('/', 'SinglePageController@displaySPA')->name('admin.spa');
    Route::get('/form-builder', 'SinglePageController@displaySPA')->name('admin.form.builder');
    Route::get('/forms', 'SinglePageController@displaySPA')->name('admin.form.list');
});

Route::any('{all}', function () {
    if (\Illuminate\Support\Facades\Auth::user()) {
        return redirect('/admin');
    }
    return redirect('/');
})->where(['all' => '.*']);

