<?php

// use App\Http\Controllers\InvoiceController;

use App\Http\Controllers\ClothController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FittingController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

Route::view("/", "home")->name("home");
Route::view("/about", "about")->name("about");

Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

// Order routes
Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::get('/order/check-date', [OrderController::class, 'checkDate'])->name('order.check-date');
Route::post('/order', [OrderController::class, 'submit'])->name('order.submit');
Route::get('/order/success/{order}', [OrderController::class, 'success'])->name('order.success');

// Tracking routes
Route::get('/tracking/phone/{phone}', [TrackingController::class, 'showByPhone'])->name('tracking.phone');
Route::get('/tracking/{orderNumber}', [TrackingController::class, 'show'])->name('tracking.show');
Route::get('/tracking', fn() => view('tracking'))->name('tracking');
Route::post('/upload-payment', [TrackingController::class, 'uploadPayment'])->name('upload.payment');

// Halaman packages (opsional)
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/packages/{code}', [PackageController::class, 'show'])->name('packages.show');

Route::get('/fitting', [FittingController::class, 'index'])->name('fitting.index');
Route::post('/fitting', [FittingController::class, 'store'])->name('fitting.store');

Route::get('/clothes', [ClothController::class, 'index'])->name('clothes.index');

Route::get('/invoice/{orderNumber}', [InvoiceController::class, 'download'])->name('invoice.download');


Route::middleware(["auth"])
    ->prefix("admin/reports")
    ->name("admin.reports.")
    ->group(function () {
        Route::get("excel", [
            App\Http\Controllers\ReportController::class,
            "exportExcel",
        ])->name("excel");
        Route::get("pdf", [
            App\Http\Controllers\ReportController::class,
            "exportPdf",
        ])->name("pdf");
    });

Route::get("/admin/invoice/{payment}", [
    InvoiceController::class,
    "generate",
])->name("admin.invoice");


Route::get('/api/package-items/{code}', function ($code) {
    $package = \App\Models\Package::with('items')->where('code', $code)->first();
    return response()->json([
        'items' => $package ? $package->items : []
    ]);
});
