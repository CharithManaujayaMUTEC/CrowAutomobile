<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use Filament\Facades\Filament;

Route::get('invoices/{id}/pdf', [InvoiceController::class, 'generateInvoice'])->name('invoices.pdf');

Route::get('/admin', function () {
    $panel = Filament::getPanel('admin');
    return $panel->getPages()[0]::make()->render();  // force render dashboard
});

Route::get('/test-alive', function () {
    return 'Laravel is alive! Current time: ' . now()->toDateTimeString();
});
