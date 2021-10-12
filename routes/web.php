<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('discussions', 'DiscussionsController');

Route::get('discussions/{channel}/channel', 'DiscussionsController@indexchannel')
->name('discussion.indexchannel');

Route::resource('discussions/{discussion}/replies', 'RepliesController');// maong ang resources "discussions/{discussion}/replies" ingana kay adeser nimo e click ang button sa add a reply ang url kay ang naka butang daan is /discussion/{then ang slug}/

Route::post('discussions/{discussion}/{reply}/best-reply', 'DiscussionsController@bestreply')->name('discussion.best-reply');

Route::get('users/notification', 'UsersController@notification')->name('users.notification');



Route::get('discussions/{discussion}/discussionNotification', 'DiscussionsController@discussionNotification')->name('discussion.notification');

Route::get('discussions/{discussion}/bestReplynotification', 'DiscussionsController@bestreplyNotification')->name('bestreply.notification');



Route::get('discussions/{discussion}/discussion-index-notification', 'DiscussionsController@indexNotification')->name('discussion.indexNotification');

Route::get('discussions/{discussion}/bestreply-index-notification', 'DiscussionsController@indexNotification')->name('bestreply.indexNotification');

Route::get('discussions/{discussion}/all-index-notification', 'DiscussionsController@indexNotification')->name('all.indexNotification');



Route::get('discussions/{discussion}/watch', 'WatchesController@watch')->name('watch.discussion');
Route::get('discussions/{discussion}/unwatch', 'WatchesController@unwatch')->name('unwatch.discussion');




