<?php

use App\Http\Controllers\PostTagController;
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

// Route::get('/', function () {
//     return view('home');
// });

// Route::view('/', 'home')->name('route-name-home');


// Route::get('/contact', function () {
//     return view('contact');
// });

//Route::view('/contact', 'contact')->name('route-name-contact');



// Route::get('blog/{id}/{welcome?}', function($id, $welcome = 1) {
//     $pages = [
//         1 => [
//             'title' => 'page 1'
//         ],
//         2 => [
//             'title' => 'different page 2'
//         ],
//     ];
//     $welcomes = [1 => '<h2>Hello from</h2>', 2 => '<h3></h3>Welcome to</h3>'];

//     return view('blog', [
//         'data' => $pages[$id],
//         'say_hello' => $welcomes[$welcome]
//     ]);
// })->name('route-name-blog');

Route::get('/', 'HomeController@home')
    ->name('route-name-home')
    // ->middleware('auth') // protects this route from being access by unregistered users
    ;
Route::get('contact', 'HomeController@contact')->name('route-name-contact');
Route::resource('/posts', 'PostController');
Route::get('/vue', 'HomeController@vue')->name('route-name-vue');
//->only(['index', 'show', 'create', 'store', 'edit', 'update']);
//->except(['destroy']);
Route::get('posts/tag/{tag}', 'PostTagController@index')->name('route-name-tags-index');

Route::resource('posts.comments', 'PostCommentController')->only(['store']);
Route::resource('users.comments', 'UserCommentController')->only(['store']);
Route::resource('users', 'UserController')->only(['show', 'edit', 'update']);

// preview the mail which will be send
Route::get('mailable', function () {
    $comment = App\Comment::find(1);
    return new App\Mail\CommentPostedMarkdown($comment);
});

Auth::routes();
