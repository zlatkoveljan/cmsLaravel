<?php
use App\Http\Controllers\Blog\PostsController;
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
//Route::get('generate-pdf','HomeController@generatePDF');

Route::get('/blog/categories/{category}', [PostsController::class, 'category'])->name('blog.category'); //pokazuva postoj po kategorija fe

Route::get('/blog/tags/{tag}', [PostsController::class, 'tag'])->name('blog.tag'); //pokazuva postoj po tags fe

Route::get('/', 'WelcomeController@index')->name('welcome');

Route::get('blog/posts/{post}', [PostsController::class, 'show'])->name('blog.show');  //pokazuva eden post frontend

Auth::routes();

Route::middleware('auth')->group ( function (){
	Route::get('/home', 'HomeController@index')->name('home');

	//Route::get('demo-generate-pdf','UsersHistoryController@demoGeneratepdf')->name('usershistory.mypdf');
	Route::get('usershistory.mypdf', 'UsersHistoryController@index');
	Route::get('usershistory.pdf', 'UsersHistoryController@pdf');


	Route::get('users-history', 'UsersHistoryController@index')->name('usershistory.index');

	Route::resource('categories', 'CategoriesController');

	Route::resource('tags', 'TagsController');

	Route::resource('posts', 'PostsController');

	Route::get('trashed-posts', 'PostsController@trashed')->name('trashed-posts.index');

	Route::put('restore-post/{post}', 'PostsController@restore')->name('restore-posts');
});

Route::middleware(['auth', 'admin'])->group(function(){
	Route::patch('users/profile', 'UsersController@update')->name('users.update-profile');
	Route::get('users/profile', 'UsersController@edit')->name('users.edit-profile');
	Route::get('users', 'UsersController@index')->name('users.index');
	Route::post('users/{user}/make-admin', 'UsersController@makeAdmin')->name('users.make-admin');
});

//Route::get('/subscribe', 'SubscriptionController@index');
//Route::post('/subscribe', 'SubscriptionController@store');
Route::post('/charge', 'CheckoutController@charge');

Route::post('/subscribe_process', 'CheckoutController@subscribe_process');