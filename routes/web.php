<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use Filament\Pages\Auth\Login;

Route::get('invoices/{id}/pdf', [InvoiceController::class, 'generateInvoice'])->name('invoices.pdf');

// Manual POST handler for Filament login (bypasses registration bug)
Route::post('/admin/login', [Login::class, 'authenticate'])
    ->middleware(['web', 'guest:admin']);
