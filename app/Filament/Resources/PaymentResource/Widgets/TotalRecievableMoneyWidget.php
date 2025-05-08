<?php

namespace App\Filament\Resources\PaymentResource\Widgets;

use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Invoice;

class TotalRecievableMoneyWidget extends BaseWidget
{
    protected static string $view = 'filament-widgets::stats-overview-widget';

    protected function getColumns(): int
    {
        return 2; // Adjust the number of columns as needed
    }

    protected function getStats(): array
    {
        // Query for today's invoices
        $invoiceQuery = Invoice::query();

        $unpaidCount = (clone $invoiceQuery)
        ->whereIn('payment_status', ['unpaid', 'Partial Paid']) // Adjust the status values as needed
        ->sum('credit_balance');

        return [
            // Total income today
            Stat::make('Total Recievable Money', $unpaidCount)
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->value($unpaidCount)
                ->color('success')
                ->icon('heroicon-o-currency-dollar'),
        ];
    }
}
