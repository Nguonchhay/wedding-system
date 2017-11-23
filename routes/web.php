<?php

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

Route::get('/home', function() {
	return redirect('/');
});

Auth::routes();

/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::group([
	'middleware' => 'auth'
], function() {
	Route::get('/', 'HomeController@index');

    Route::get('/guests/import', 'GuestController@import')->name('guests.import');
    Route::post('/guests/importGuest', 'GuestController@importGuest')->name('guests.import_guest');
    Route::resource('guests', 'GuestController');

	Route::resource('weddings', 'WeddingController');
    Route::group([
        'prefix' => 'weddings'
    ], function() {
        Route::get('/{id}/invite', 'WeddingController@invite')->name('weddings.invite');
        Route::post('/{id}/invite-guest', 'WeddingController@inviteGuest')->name('weddings.invite_guest');

        Route::get('/{id}/detail', 'WeddingController@show')->name('weddings.show');
    });

    Route::resource('wedding_invitations', 'WeddingInvitationController');
    Route::group([
        'prefix' => 'wedding_invitations'
    ], function() {
        Route::get('/{wedding_id}/index', 'WeddingInvitationController@index')->name('wedding_invitations.index');
    });

	Route::resource('expenses', 'ExpenseController');
	Route::resource('expense_details', 'ExpenseDetailController');

	Route::group([
		'prefix' => 'expense_details'
	], function() {
		Route::get('/{expense}/create', 'ExpenseDetailController@create');
	});

	Route::resource('guest_groups', 'GuestGroupController');
    Route::resource('users', 'UserController');
});