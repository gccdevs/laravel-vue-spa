<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', 'UsersApi@me')->name('me');

Route::middleware('auth:api')->group( function () {
    Route::post('password/change', 'UsersApi@changePassword')->name('backend.password.change');
    Route::post('save-notes', 'HomeApi@saveNote')->name('backend.saveNote');
    Route::get('get-notes', 'HomeApi@getNote')->name('backend.getNote');

    Route::post('switch-lang', 'UsersApi@switch')->name('backend.switch.lang');

    Route::get('forms', 'FormBuilderApi@show')->name('backend.form.list');
    Route::get('form/{id}', 'FormBuilderApi@showSingleForm')->name('backend.form.single');
    Route::post('form-builder/create', 'FormBuilderApi@create')->name('backend.form.create');
    Route::post('form-builder/edit', 'FormBuilderApi@update')->name('backend.form.edit');
});

/*
 **********************************************************************************************
 * Frontend
 */
Route::group(['prefix' => 'events'], function () {
    Route::get('/', 'EventsApi@index')->name('events');
    Route::get('/{event}', 'EventsApi@show')->name('event.single');
    Route::post('/{event}/submit', 'EventsApi@submit')->name('event.single.submit');
});

Route::post('/fund/charge', 'FundraisingApi@takeCharge')->name('fund.charge');
