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

Auth::routes();

Route::get('/test-video', function () {
    return view('partials.url-video-player');
});

// แสดงรายการ ซีรีย์/ตอน index
Route::get('/series', function () {
    $series = \App\Serie::all();

    return view('serie.index')->with([
        'series' => $series
    ]);
    
})->name('series');

// แสดงฟอร์มสร้าง ซีรีย์/ตอน
Route::get('/series/create', function () {
    return view('serie.create');
});

// รับข้อมูลจากฟอร์มสร้าง ซีรีย์/ตอน แล้วบันทึกลงตาราง
Route::post('/series', function () {
    $data = \Request::all();

    \App\Serie::create($data);

    return redirect('series');
});

