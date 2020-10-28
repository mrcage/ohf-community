<?php

namespace App\Http\Controllers\Accounting;

use App\Exports\Accounting\MoneyTransactionsExport;
use App\Exports\Accounting\MoneyTransactionsMonthsExport;
use App\Exports\Accounting\WeblingMoneyTransactionsExport;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Export\ExportableActions;
use App\Models\Accounting\MoneyTransaction;
use App\Models\Accounting\Supplier;
use App\Models\Accounting\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Setting;

class MoneyTransactionsController extends Controller
{
    use ExportableActions;

    public function index(Wallet $wallet)
    {
        return view('accounting.transactions', [
            'wallet' => $wallet,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index2(Wallet $wallet, Request $request)
    {
        $this->authorize('viewAny', MoneyTransaction::class);
        $this->authorize('view', $wallet);

        $request->validate([
            'date_start' => [
                'nullable',
                'date',
                'before_or_equal:' . Carbon::today(),
            ],
            'date_end' => [
                'nullable',
                'date',
                'before_or_equal:' . Carbon::today(),
            ],
            'type' => [
                'nullable',
                Rule::in(['income', 'spending']),
            ],
            'month' => 'nullable|regex:/[0-1]?[1-9]/',
            'year' => 'nullable|integer|min:2017|max:' . Carbon::today()->year,
            'sortColumn' => 'nullable|in:date,created_at,category,secondary_category,project,location,cost_center,attendee,receipt_no',
            'sortOrder' => 'nullable|in:asc,desc',
        ]);

        $sortColumns = [
            'date' => __('app.date'),
            'category' => __('app.category'),
            'secondary_category' => __('app.secondary_category'),
            'project' => __('app.project'),
            'location' => __('app.location'),
            'cost_center' => __('accounting.cost_center'),
            'attendee' => __('accounting.attendee'),
            'receipt_no' => __('accounting.receipt'),
            'created_at' => __('app.registered'),
        ];
        $sortColumn = session('accounting.sortColumn', self::showIntermediateBalances() ? 'receipt_no' : 'created_at');
        $sortOrder = session('accounting.sortOrder', 'desc');
        if (isset($request->sortColumn)) {
            $sortColumn = $request->sortColumn;
            session(['accounting.sortColumn' => $sortColumn]);
        }
        if (isset($request->sortOrder)) {
            $sortOrder = $request->sortOrder;
            session(['accounting.sortOrder' => $sortOrder]);
        }

        if ($request->query('reset_filter') != null) {
            session(['accounting.filter' => []]);
        }
        $filter = session('accounting.filter', []);
        foreach (config('accounting.filter_columns') as $col) {
            if (! empty($request->filter[$col])) {
                $filter[$col] = $request->filter[$col];
            } elseif (isset($request->filter)) {
                unset($filter[$col]);
            }
        }
        if (! empty($request->filter['date_start'])) {
            $filter['date_start'] = $request->filter['date_start'];
        } elseif (isset($request->filter)) {
            unset($filter['date_start']);
        }
        if (! empty($request->filter['date_end'])) {
            $filter['date_end'] = $request->filter['date_end'];
        } elseif (isset($request->filter)) {
            unset($filter['date_end']);
        }
        session(['accounting.filter' => $filter]);

        $query = MoneyTransaction::query()
            ->forWallet($wallet)
            ->forFilter($filter)
            ->orderBy($sortColumn, $sortOrder)
            ->orderBy('created_at', 'DESC');

        // Get results
        $transactions = $query->paginate(250);

        // Single receipt no. query
        if ($transactions->count() == 1 && ! empty($filter['receipt_no'])) {
            session(['accounting.filter' => []]);
            return redirect()->route('accounting.transactions.show', $transactions->first());
        }

        $hasSuppliers = Supplier::count() > 0;

        return view('accounting.transactions.index', [
            'transactions' => $transactions,
            'filter' => $filter,
            'sortColumns' => $sortColumns,
            'sortColumn' => $sortColumn,
            'sortOrder' => $sortOrder,
            'attendees' => MoneyTransaction::attendees(),
            'categories' => self::getCategories(true),
            'fixed_categories' => Setting::has('accounting.transactions.categories'),
            'secondary_categories' => self::useSecondaryCategories() ? self::getSecondaryCategories(true) : null,
            'fixed_secondary_categories' => Setting::has('accounting.transactions.secondary_categories'),
            'projects' => self::getProjects(true),
            'fixed_projects' => Setting::has('accounting.transactions.projects'),
            'locations' => self::useLocations() ? self::getLocations(true) : null,
            'fixed_locations' => Setting::has('accounting.transactions.locations'),
            'cost_centers' => self::useCostCenters() ? self::getCostCenters(true) : null,
            'fixed_cost_centers' => Setting::has('accounting.transactions.cost_centers'),
            'wallet' => $wallet,
            'has_multiple_wallets' => Wallet::count() > 1,
            'intermediate_balances' => ($sortColumn == 'receipt_no' && self::showIntermediateBalances()) ? self::getIntermediateBalances($wallet) : null,
            'has_suppliers' => $hasSuppliers,
            'suppliers' => $hasSuppliers ? Supplier::query()
                ->has('transactions')
                ->select('id', 'name', 'category')
                ->orderBy('name')
                ->get() : [],
        ]);
    }

    private static function getCategories(?bool $onlyExisting = false): array
    {
        if (! $onlyExisting && Setting::has('accounting.transactions.categories')) {
            return collect(Setting::get('accounting.transactions.categories'))
                ->sort()
                ->toArray();
        }
        return MoneyTransaction::categories();
    }

    private static function useSecondaryCategories(): bool
    {
        return Setting::get('accounting.transactions.use_secondary_categories') ?? false;
    }

    private static function getSecondaryCategories(?bool $onlyExisting = false): array
    {
        if (! $onlyExisting && Setting::has('accounting.transactions.secondary_categories')) {
            return collect(Setting::get('accounting.transactions.secondary_categories'))
                ->sort()
                ->toArray();
        }
        return MoneyTransaction::secondaryCategories();
    }

    private static function getProjects(?bool $onlyExisting = false): array
    {
        if (! $onlyExisting && Setting::has('accounting.transactions.projects')) {
            return collect(Setting::get('accounting.transactions.projects'))
                ->sort()
                ->toArray();
        }
        return MoneyTransaction::projects();
    }

    private static function useLocations(): bool
    {
        return Setting::get('accounting.transactions.use_locations') ?? false;
    }

    private static function getLocations(?bool $onlyExisting = false): array
    {
        if (! $onlyExisting && Setting::has('accounting.transactions.locations')) {
            return collect(Setting::get('accounting.transactions.locations'))
                ->sort()
                ->toArray();
        }
        return MoneyTransaction::locations();
    }

    private static function useCostCenters(): bool
    {
        return Setting::get('accounting.transactions.use_cost_centers') ?? false;
    }

    private static function getCostCenters(?bool $onlyExisting = false): array
    {
        if (! $onlyExisting && Setting::has('accounting.transactions.cost_centers')) {
            return collect(Setting::get('accounting.transactions.cost_centers'))
                ->sort()
                ->toArray();
        }
        return MoneyTransaction::costCenters();
    }

    private static function showIntermediateBalances(): bool
    {
        return Setting::get('accounting.transactions.show_intermediate_balances') ?? false;
    }

    private static function getIntermediateBalances(Wallet $wallet): array
    {
        $transactions = MoneyTransaction::query()
            ->forWallet($wallet)
            ->orderBy('receipt_no', 'ASC')
            ->get();

        $intermediate_balances = [];
        $intermediate_balance = 0;
        foreach ($transactions as $transaction) {
            if ($transaction->type == 'income') {
                $intermediate_balance += $transaction->amount;
            } else {
                $intermediate_balance -= $transaction->amount;
            }
            $intermediate_balances[$transaction->id] = $intermediate_balance;
        }

        return $intermediate_balances;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Wallet $wallet)
    {
        $this->authorize('create', MoneyTransaction::class);

        return view('accounting.transactions', [
            'wallet' => $wallet,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accounting\MoneyTransaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(MoneyTransaction $transaction)
    {
        $this->authorize('view', $transaction);

        return view('accounting.transactions', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Accounting\MoneyTransaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(MoneyTransaction $transaction)
    {
        $this->authorize('update', $transaction);

        return view('accounting.transactions', [
            'transaction' => $transaction,
        ]);
    }

    protected function exportAuthorize()
    {
        $this->authorize('viewAny', MoneyTransaction::class);
    }

    protected function exportView(): string
    {
        return 'accounting.transactions.export';
    }

    protected function exportViewArgs(): array
    {
        $filter = session('accounting.filter', []);
        return [
            'wallet' => Wallet::findOrFail(request()->route('wallet')),
            'columnsSelection' => [
                'all' => __('app.all'),
                'webling' => __('accounting.selection_for_webling'),
            ],
            'columns' => 'all',
            'groupings' => [
                'none' => __('app.none'),
                'monthly' => __('app.monthly'),
            ],
            'grouping' => 'none',
            'selections' => ! empty($filter) ? [
                'all' => __('app.all_records'),
                'filtered' => __('app.selected_records_according_to_current_filter'),
            ] : null,
            'selection' => 'all',
        ];
    }

    protected function exportValidateArgs(): array
    {
        return [
            'columns' => [
                'required',
                Rule::in(['all', 'webling']),
            ],
            'grouping' => [
                'required',
                Rule::in(['none', 'monthly']),
            ],
            'selection' => [
                'nullable',
                Rule::in(['all', 'filtered']),
            ],
        ];
    }

    protected function exportFilename(Request $request): string
    {
        $wallet = Wallet::findOrFail($request->route('wallet'));
        return config('app.name') . ' ' . __('accounting.accounting') . ' [' . $wallet->name . '] (' . Carbon::now()->toDateString() . ')';
    }

    protected function exportExportable(Request $request)
    {
        $wallet = Wallet::findOrFail($request->route('wallet'));
        $filter = $request->selection == 'filtered' ? session('accounting.filter', []) : [];
        if ($request->grouping == 'monthly') {
            return new MoneyTransactionsMonthsExport($wallet, $filter);
        }
        if ($request->columns == 'webling') {
            return new WeblingMoneyTransactionsExport($wallet, $filter);
        }
        return new MoneyTransactionsExport($wallet, $filter);
    }
}
