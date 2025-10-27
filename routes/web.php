<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\HouseController;
use App\Http\Controllers\Product\HouseFeatureController;
use App\Http\Controllers\ContactController;

Route::get('/', [HouseController::class, 'welcome'])
    ->middleware('guest')
    ->name('welcome');

Route::get('/view/house/{house}/features', [HouseFeatureController::class, 'visitorView'])
    ->name('visitor.house_features');
    
Route::post('/view/house/{house}/contact', [ContactController::class, 'store'])
    ->name('visitor.contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/houses/{house}/features', [HouseFeatureController::class, 'index'])
    ->name('house_features.index');
    
Route::post('/houses/{house}/features', [HouseFeatureController::class, 'store'])
    ->middleware('auth')
    ->name('house_features.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/houses', [HouseController::class,'index'])->name('houses.index');
    Route::get('/houses/create',[HouseController::class,'create'])->name('houses.create');
    Route::post('create',[HouseController::class,'store'])->name('houses.store');

    Route::get('/houses/{house}/edit', [HouseController::class, 'edit'])->name('houses.edit');
    Route::put('/houses/{house}', [HouseController::class, 'update'])->name('houses.update');
});

Route::middleware('auth')->group(function (){
    Route::get('/inquiries', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::patch('/contacts/{contact}/read', [ContactController::class, 'markRead'])->name('contacts.markRead');
});
require __DIR__.'/auth.php';
