<?php

namespace App\Http\Controllers\Accounting\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\StoreControlled;
use App\Http\Requests\Accounting\StoreTransaction;
use App\Http\Requests\Accounting\StoreUndoBooking;
use App\Models\Accounting\MoneyTransaction;
use App\Http\Resources\Accounting\MoneyTransaction as MoneyTransactionResource;
use App\Models\Accounting\Wallet;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Setting;

class MoneyTransactionsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Accounting\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function index(Wallet $wallet, Request $request)
    {
        $this->authorize('viewAny', MoneyTransaction::class);

        $request->validate([
            'filter' => [
                'nullable',
            ],
            'page' => [
                'nullable',
                'integer',
                'min:1',
            ],
            'pageSize' => [
                'nullable',
                'integer',
                'min:1',
            ],
            'sortBy' => [
                'nullable',
                'alpha_dash',
                'filled',
                Rule::in([
                    'date',
                    'receipt_no',
                    'amount',
                    'created_at',
                    'category',
                    'secondary_category',
                    'project',
                    'location',
                    'cost_center',
                    'attendee',
                ]),
            ],
            'sortDirection' => [
                'nullable',
                'in:asc,desc',
            ],
        ]);

        // Sorting, pagination and filter
        $sortBy = $request->input('sortBy', 'created_at');
        $sortDirection = $request->input('sortDirection', 'desc');
        $pageSize = $request->input('pageSize', 25);
        $filter = trim($request->input('filter', ''));

        return MoneyTransactionResource::collection($wallet->transactions()
            ->with('supplier')
            ->orderBy($sortBy, $sortDirection)
            ->forFilter($filter)
            ->paginate($pageSize));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Accounting\StoreTransaction  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Wallet $wallet, StoreTransaction $request)
    {
        $this->authorize('create', MoneyTransaction::class);
        $this->authorize('view', $wallet);

        $transaction = new MoneyTransaction();
        $transaction->date = $request->date;
        $transaction->receipt_no = $request->receipt_no;
        $transaction->type = $request->type;
        $transaction->amount = $request->amount;
        $transaction->attendee = $request->attendee;
        $transaction->category = $request->category;
        if (self::useSecondaryCategories()) {
            $transaction->secondary_category = $request->secondary_category;
        }
        $transaction->project = $request->project;
        if (self::useLocations()) {
            $transaction->location = $request->location;
        }
        if (self::useCostCenters()) {
            $transaction->cost_center = $request->cost_center;
        }
        $transaction->description = $request->description;
        $transaction->remarks = $request->remarks;

        $transaction->supplier()->associate($request->input('supplier_id'));

        $transaction->wallet()->associate($wallet);

        if (isset($request->receipt_picture) && is_array($request->receipt_picture)) {
            for ($i = 0; $i < count($request->receipt_picture); $i++) {
                $transaction->addReceiptPicture($request->file('receipt_picture')[$i]);
            }
        }

        $transaction->save();

        return self::showResource($transaction)
            ->response()
            ->setStatusCode(Response::HTTP_CREATED)
            ->header('Location', route('api.accounting.transactions.show', $transaction));
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

        return self::showResource($transaction);
    }

    private static function showResource($transaction): JsonResource
    {
        return new MoneyTransactionResource($transaction
            ->load('supplier')
            ->load('controller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Accounting\MoneyTransaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTransaction $request, MoneyTransaction $transaction)
    {
        $this->authorize('update', $transaction);

        $transaction->date = $request->date;
        $transaction->receipt_no = $request->receipt_no;
        $transaction->type = $request->type;
        $transaction->amount = $request->amount;
        $transaction->attendee = $request->attendee;
        $transaction->category = $request->category;
        if (self::useSecondaryCategories()) {
            $transaction->secondary_category = $request->secondary_category;
        }
        $transaction->project = $request->project;
        if (self::useLocations()) {
            $transaction->location = $request->location;
        }
        if (self::useCostCenters()) {
            $transaction->cost_center = $request->cost_center;
        }
        $transaction->description = $request->description;
        $transaction->remarks = $request->remarks;

        $transaction->supplier()->associate($request->input('supplier_id'));

        if (isset($request->remove_receipt_picture) && is_array($request->remove_receipt_picture)) {
            foreach ($request->remove_receipt_picture as $picture) {
                $transaction->deleteReceiptPicture($picture);
            }
        }
        elseif (isset($request->receipt_picture) && is_array($request->receipt_picture)) {
            for ($i = 0; $i < count($request->receipt_picture); $i++) {
                $transaction->addReceiptPicture($request->file('receipt_picture')[$i]);
            }
        }

        $transaction->save();

        return self::showResource($transaction);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Accounting\MoneyTransaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(MoneyTransaction $transaction)
    {
        $this->authorize('delete', $transaction);

        $wallet = $transaction->wallet;

        $transaction->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function updateReceipt(Request $request, MoneyTransaction $transaction)
    {
        $this->authorize('update', $transaction);

        $request->validate([
            'img' => [
                'array',
            ],
            'img.*' => [
                'file',
                'mimetypes:image/*,application/pdf',
            ],
        ]);

        $transaction->deleteReceiptPictures();
        for ($i = 0; $i < count($request->img); $i++) {
            $transaction->addReceiptPicture($request->file('img')[$i]);
        }
        $transaction->save();

        return collect($transaction->receipt_pictures)
            ->map(fn ($f) => Storage::url($f));
    }

    public function markControlled(StoreControlled $request, MoneyTransaction $transaction)
    {
        $this->authorize('update', $transaction);

        $transaction->controlled_at = now();
        $transaction->controlled_by = $request->user()->id;
        $transaction->save();

        return self::showResource($transaction);
    }

    public function undoControlled(MoneyTransaction $transaction)
    {
        $this->authorize('undoControlling', $transaction);

        $transaction->controlled_at = null;
        $transaction->controlled_by = null;
        $transaction->save();

        return self::showResource($transaction);
    }

    public function undoBooking(MoneyTransaction $transaction, StoreUndoBooking $request)
    {
        $this->authorize('undoBooking', $transaction);

        $transaction->booked = false;
        $transaction->external_id = null;
        $transaction->save();

        return self::showResource($transaction);
    }

    public function attendees()
    {
        return response()->json([
            'data' => MoneyTransaction::attendees(),
        ]);
    }

    public function categories(Request $request): array
    {
        return [
            'data' => self::getCategories($request->has('existing')),
            'meta' => [
                'fixed' => Setting::has('accounting.transactions.categories'),
            ],
        ];
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

    public function secondaryCategories(Request $request): array
    {
        return [
            'data' => self::useSecondaryCategories() ? self::getSecondaryCategories($request->has('existing')) : [],
            'meta' => [
                'enabled' => self::useSecondaryCategories(),
                'fixed' => Setting::has('accounting.transactions.secondary_categories'),
            ],
        ];
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

    public function projects(Request $request): array
    {
        return [
            'data' => self::getProjects($request->has('existing')),
            'meta' => [
                'fixed' => Setting::has('accounting.transactions.projects'),
            ],
        ];
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

    public function locations(Request $request): array
    {
        return [
            'data' => self::useLocations() ? self::getLocations($request->has('existing')) : [],
            'meta' => [
                'enabled' => self::useLocations(),
                'fixed' => Setting::has('accounting.transactions.locations'),
            ],
        ];
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

    public function costCenters(Request $request): array
    {
        return [
            'data' => self::useCostCenters() ? self::getCostCenters($request->has('existing')) : [],
            'meta' => [
                'enabled' => self::useCostCenters(),
                'fixed' => Setting::has('accounting.transactions.cost_centers'),
            ],
        ];
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

    public function nextFreeReceiptNumber(Wallet $wallet)
    {
        return [
            'data' => $wallet->nextFreeReceiptNumber,
        ];
    }
}
