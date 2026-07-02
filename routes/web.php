<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiController;
use App\Http\Controllers\HistoryController;

Route::get('/', function (Request $request) {
    $lang = $request->query('lang', 'en');

    if (! in_array($lang, ['en', 'fa', 'ar'], true)) {
        $lang = 'en';
    }

    app()->setLocale($lang);

    return view('caption_generator', [
        'initialLang' => $lang,
    ]);
});

Route::get('/history', [HistoryController::class, 'index']);
Route::delete('/history', [HistoryController::class, 'clear']);

Route::post('/generate-caption', [AiController::class, 'generateCaption']);
