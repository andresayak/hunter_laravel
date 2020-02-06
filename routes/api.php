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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/items', function (Request $request) {
    return \App\Models\UploadList::with('domains')->get();
});

Route::get('/item/{uploadList}', function (Request $request, \App\Models\UploadList $uploadList) {
    return $uploadList;
});

Route::get('/item/{uploadList}/remove', function (Request $request, \App\Models\UploadList $uploadList) {
    $uploadList->delete();
    return [
        'status'    =>  true
    ];
});

Route::get('/domain/{domain}', function (Request $request, \App\Models\Domain $domain) {
    return $domain;
});

Route::get('/domain/{domain}/remove', function (Request $request, \App\Models\Domain $domain) {
    $domain->delete();
    return [
        'status'    =>  true
    ];
});

Route::post('/add', 'IndexController@add');

