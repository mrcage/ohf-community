<?php

namespace App\Exports\Accounting;

use App\Exports\Accounting\Sheets\MoneyTransactionsMonthSheet;
use App\Exports\Accounting\Sheets\MoneyTransactionsSummarySheet;
use App\Exports\DefaultFormatting;
use App\Models\Accounting\MoneyTransaction;
use App\Models\Accounting\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;

class MoneyTransactionsMonthsExport implements WithMultipleSheets, WithEvents
{
    use Exportable, DefaultFormatting;

    /**
     * Filter conditions
     *
     * @var array<string>
     */
    private array $filter;

    private Wallet $wallet;

    public function __construct(Wallet $wallet, $filter = [])
    {
        $this->filter = $filter;
        $this->wallet = $wallet;

        setlocale(LC_TIME, \App::getLocale());
    }

    public function sheets(): array
    {
        $months = MoneyTransaction::query()
            ->forWallet($this->wallet)
            ->forFilter($this->filter, true)
            ->selectRaw('MONTH(date) as month')
            ->selectRaw('YEAR(date) as year')
            ->groupBy(DB::raw('MONTH(date)'))
            ->groupBy(DB::raw('YEAR(date)'))
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get()
            ->map(fn ($e) => (new Carbon($e->year.'-'.$e->month.'-01'))->startOfMonth())
            ->toArray();

        $sheets = [];

        // Transactions by month
        foreach ($months as $month) {
            $sheet = new MoneyTransactionsMonthSheet($this->wallet, $month, $this->filter);
            $sheet->orientation = 'landscape';
            $sheets[] = $sheet;
        }

        // Summary
        $sheets[] = new MoneyTransactionsSummarySheet($months);

        return $sheets;
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function (BeforeExport $event) {
                $spreadsheet = $event->writer->getDelegate();
                $this->setupSpreadsheet($spreadsheet);
            },
            BeforeWriting::class => function (BeforeWriting $event) {
                $spreadsheet = $event->writer->getDelegate();
                $spreadsheet->setActiveSheetIndex($spreadsheet->getSheetCount() - 1);
            },
        ];
    }
}
