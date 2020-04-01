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
Route::get('/forum', 'ForumController@index')->name('forum');

Route::get('/auth/redirect/{provider}', 'SocialController@redirect');
Route::get('/callback/{provider}', 'SocialController@callback');

Route::get('/channels/{channel}',['uses'=>'ChannelController@show','as'=>'channels.show']);
Route::get('/discussions/{discussion}',['uses'=>'DiscussionController@show','as'=>'discussions.show']);

Route::get('/send', 'HomeController@sendNotification');

Route::group(['middleware'=>'auth'], function(){	
	Route::resource('channel','ChannelController')->middleware('admin');
	Route::resource('discussion','DiscussionController');
	Route::get('/discussion/watch/{id}',['uses'=>'WatcherController@watch', 'as'=>'discussion.watch']);
	Route::get('/discussion/unwatch/{id}',['uses'=>'WatcherController@unwatch', 'as'=>'discussion.unwatch']);
	Route::post('/reply/create', ['uses'=>'ReplyController@create', 'as'=> 'reply.create']);
	Route::post('/reply/update/{id}',['uses'=>'ReplyController@update','as'=>'reply.update']);
	Route::get('/reply/best/{id}',['uses'=>'ReplyController@best','as'=>'reply.best']);
	Route::get('/reply/like/{id}',['uses'=>'ReplyController@like','as'=>'reply.like']);
	Route::get('/reply/dislike/{id}',['uses'=>'ReplyController@dislike','as'=>'reply.dislike']);
});
