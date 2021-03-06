<?php

namespace App\Http\Controllers\Accounting\API;

use App\Http\Controllers\Controller;
use App\Models\Accounting\MoneyTransaction;
use Illuminate\Http\Request;

class MoneyTransactionsController extends Controller
{
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

        return response(null, 204);
    }
}
