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

Auth::routes();

$router->get('/', 'ContactController@index')->name('contact_list');
$router->get('contact/create', 'ContactController@create')->name('contact_create');
$router->post('contact/store', 'ContactController@store')->name('contact_store');
$router->get('contact/view/{contact}', 'ContactController@show')->name('contact_view');
$router->get('contact/edit/{contact}', 'ContactController@edit')->name('contact_edit');
$router->post('contact/update/{contact}', 'ContactController@update')->name('contact_update');
$router->post('contact/delete/{contact}', 'ContactController@destroy')->name('contact_delete');
