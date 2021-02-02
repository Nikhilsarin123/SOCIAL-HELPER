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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/add', function () {
    return view('message');
});


Route::get('login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');
Route::group(['middleware' => [
    'auth'
]], function(){

    Route::get('/user', 'GraphController@retrieveUserProfile');
 
    Route::post('/userer', 'GraphController@publishToProfile');

     Route::post('/page', 'GraphController@publishToPage');
     Route::get('/pagelist/{id}', 'GraphController@Getpages');
     Route::get('/grouplist/{id}', 'GraphController@Getgroups');
     Route::get('/per/{page_id}', 'GraphController@getPageAccessToken');
          Route::post('/group', 'GraphController@publishTogroup')->name('group.store');
          Route::post('/page', 'GraphController@publishTopage')->name('page.store');

       Route::post('/pphoto', 'GraphController@publishPhotoTopage')->name('pphoto.store');
          Route::post('/plink', 'GraphController@publishLinkTopage')->name('plink.store');
             Route::post('/pvideo', 'GraphController@publishVideoTopage')->name('pvideo.store');
                Route::post('/gphoto', 'GraphController@publishPhotoTogroup')->name('gphoto.store');
                   Route::post('/glink', 'GraphController@publishLinkTogroup')->name('glink.store');
                      Route::post('/gvideo', 'GraphController@publishVideoTogroup')->name('gvideo.store');
                       Route::post('/pshow', 'GraphController@activepagefeed')->name('pshow.store');
                        Route::post('/gshow', 'GraphController@activegroupfeed')->name('gshow.store');
                                 Route::get('/deleteppost/{id}', 'GraphController@deleteppost');
                            Route::post('/page', 'GraphController@publishTopage')->name('page.store');



});
Route::get('/post', 'facebookController@logineer') ;



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
