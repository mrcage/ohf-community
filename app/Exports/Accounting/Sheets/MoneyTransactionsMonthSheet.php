<?php

namespace App\Exports\Accounting\Sheets;

use App\Exports\Accounting\BaseMoneyTransactionsExport;
use App\Models\Accounting\MoneyTransaction;
use App\Models\Accounting\Wallet;
use Carbon\Carbon;

class MoneyTransactionsMonthSheet extends BaseMoneyTransactionsExport
{
    /**
     * Month date
     */
    private Carbon $month;

    /**
     * Filter conditions
     *
     * @var array<string>
     */
    private array $filter;

    private Wallet $wallet;

    public function __construct(Wallet $wallet, Carbon $month, ?array $filter = [])
    {
        $this->wallet = $wallet;
        $this->month = $month;
        $this->filter = $filter;
    }

    public function query(): \Illuminate\Database\Eloquent\Builder
    {
        $dateFrom = $this->month;
        $dateTo = (clone $dateFrom)->endOfMonth();

        return MoneyTransaction::query()
            ->forWallet($this->wallet)
            ->forFilter($this->filter, true)
            ->orderBy('date', 'ASC')
            ->orderBy('created_at', 'ASC')
            ->whereDate('date', '>=', $dateFrom)
            ->whereDate('date', '<=', $dateTo);
    }

    public function title(): string
    {
        return $this->month->formatLocalized('%B %Y');
    }
}
