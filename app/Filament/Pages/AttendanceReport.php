<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\{
    DatePicker, Select
};
use App\Models\Attendance;

class AttendanceReport extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Attendance Report';
    protected static ?string $navigationGroup = 'Attendance Management';
    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.attendance-report';

    protected function getTableQuery()
    {
        return Attendance::query()->with('employee');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('date')->date()->sortable(),
            TextColumn::make('employee.name')->searchable(),
            TextColumn::make('status')->badge()->colors([
                'success' => 'present',
                'danger' => 'absent',
                'warning' => 'late',
                'info' => 'leave',
            ]),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\Filter::make('date')
                ->form([
                    DatePicker::make('from'),
                    DatePicker::make('to'),
                ])
                ->query(fn ($query, $data) =>
                    $query
                        ->when($data['from'], fn ($q) => $q->whereDate('date', '>=', $data['from']))
                        ->when($data['to'], fn ($q) => $q->whereDate('date', '<=', $data['to']))
                ),

            Tables\Filters\SelectFilter::make('employee_id')
                ->relationship('employee', 'name'),
        ];
    }
}

