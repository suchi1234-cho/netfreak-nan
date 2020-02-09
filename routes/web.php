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

Route::get('/home', function () {
    return redirect('series');
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
Route::get('/series/{serieId}/episodes/create', function ($serieId) {
    return view('episode.create')->with(['serieId' => $serieId]);
});

// รับข้อมูลจากฟอร์มสร้าง ซีรีย์/ตอน แล้วบันทึกลงตาราง
Route::post('/series', function () {
    $data = \Request::all();

    \App\Serie::create($data);

    return redirect('series');
});

Route::post('/series/{id}/episodes', function ($id) {
    $data = \Request::all();

    $episode = \App\Episode::create($data);

    $episode->serie_id = $id;

    $episode->save();

    return redirect('/series/' . $id);
});

// แสดง ตอน ที่อยู่ในซีรีย์
Route::get('/series/{serie}', function (\App\Serie $serie) {
    // db query
    // $serie = \App\Serie::find($id);

    // return template + data
    return view('serie.show')->with([
        'serie' => $serie
    ]);
});

Route::get('episodes/{episode}', function(\App\Episode $episode) {
    
    // return template + data
    $playerTemplate= 'partials.' . $episode->hosting . '-video-player';
    return view('episode.show')->with([
        'episode' => $episode,
        'playerTemplate' => $playerTemplate,
    ]);
    //return view('episode.show')->with(['episode'=> $episode
    
    //]);
});

