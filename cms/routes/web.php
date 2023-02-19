<?php

use App\Book;
use Illuminate\Http\Request;


/**
* 本の一覧表示(books.blade.php) 課題2.1
*/
Route::get('/', 'BooksController@index');


/**
* 本を追加 
*/
Route::post('/books', 'BooksController@store');


/** 
* 更新画面 課題1.2 課題2.2
*/
Route::post('/booksedit/{books}', 'BooksController@edit');


/**
* 更新処理 課題1.2
*/
Route::post('/books/update', 'BooksController@update');


/**
* 本を削除 課題2.3
*/
Route::delete('/book/{book}', 'BooksController@destroy');

//Auth
Auth::routes();
Route::get('/home', 'BooksController@index')->name('home');

