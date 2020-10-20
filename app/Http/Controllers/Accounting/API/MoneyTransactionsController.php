<?php

namespace App\Http\Controllers\Accounting\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\StoreControlled;
use App\Http\Requests\Accounting\StoreUndoBooking;
use App\Models\Accounting\MoneyTransaction;
use App\Http\Resources\Accounting\MoneyTransaction as MoneyTransactionResource;
use App\Models\Accounting\Wallet;
use App\Support\Accounting\Webling\Entities\Entrygroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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
     * Display the specified resource.
     *
     * @param  \App\Models\Accounting\MoneyTransaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(MoneyTransaction $transaction)
    {
        return new MoneyTransactionResource($transaction
            ->load('supplier')
            ->load('controller'));
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

        return collect($transaction->receipt_pictures)->map(fn ($f) => Storage::url($f));
    }

    public function markControlled(StoreControlled $request, MoneyTransaction $transaction)
    {
        $this->authorize('update', $transaction);

        $transaction->controlled_at = now();
        $transaction->controlled_by = $request->user()->id;
        $transaction->save();

        return $this->show($transaction);
    }

    public function undoControlled(MoneyTransaction $transaction)
    {
        $this->authorize('undoControlling', $transaction);

        $transaction->controlled_at = null;
        $transaction->controlled_by = null;
        $transaction->save();

        return $this->show($transaction);
    }

    public function undoBooking(MoneyTransaction $transaction, StoreUndoBooking $request)
    {
        $this->authorize('undoBooking', $transaction);

        $transaction->booked = false;
        $transaction->external_id = null;
        $transaction->save();

        return $this->show($transaction);
    }
}
