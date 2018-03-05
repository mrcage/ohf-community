<?php

namespace App\Http\Controllers\Donations;

use App\Donor;
use App\Donation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Donations\StoreDonation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use MrCage\EzvExchangeRates\EzvExchangeRates;

class DonationController extends Controller
{
    /**
     * Register a new donation.
     *
     * @param  \App\Donor  $donor
     * @return \Illuminate\Http\Response
     */
    public function register(Donor $donor)
    {
        $this->authorize('create', Donation::class);

        return view('donations.donations.register', [
            'donor' => $donor,
            'currencies' => Config::get('donations.currencies'),
            'channels' => Donation::select('channel')->distinct()->get()->pluck('channel')->toArray(),
        ]);
    }

    /**
     * Stores a new donation.
     *
     * @param  \App\Http\Requests\Donations\StoreDonation  $request
     * @param  \App\Donor  $donor
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDonation $request, Donor $donor)
    {
        $this->authorize('create', Donation::class);

        $date = new Carbon($request->date);
        if ($date->isFuture()) {
            $date = Carbon::today();
        }

        if ($request->currency == Config::get('donations.base_currency')) {
            $exchange_amount = $request->amount;
        } else {
            if (!empty($request->exchange_rate)) {
                $exchange_rate = $request->exchange_rate;
            } else {
                try {
                    $exchange_rate = EzvExchangeRates::getExchangeRate($request->currency, $date);
                } catch (\Exception $e) {
                    Log::error($e);
                    // If exchange cannot be determined, redirect to advanced registration form, where exchange can be specified
                    return redirect()
                        ->route('donations.create', $donor)
                        ->withInput()
                        ->with('error', __('app.an_error_happened'). ': ' . $e->getMessage());
                }
            }
            $exchange_amount = $request->amount * $exchange_rate;
        }

        $donation = new Donation();
        $donation->date = $date;
        $donation->amount = $request->amount;
        $donation->currency = $request->currency;
        $donation->exchange_amount = $exchange_amount;
        $donation->channel = $request->channel;
        $donation->purpose = $request->purpose;
        $donation->reference = $request->reference;
        $donor->donations()->save($donation);
        return redirect()->route('donors.show', $donor)
            ->with('success', __('donations.donation_registered', [ 'amount' => $request->amount, 'currency' => $request->currency ]));;
    }

    /**
     * Exports the donations of a donor
     *
     * @param  \App\Donor  $donor
     * @return \Illuminate\Http\Response
     */
    public function export(Donor $donor)
    {
        $this->authorize('list', Donation::class);

        \Excel::create('OHF_Community_Donors_' . str_replace(' ', '_', $donor->name) . '_' . Carbon::now()->toDateString(), function($excel) use($donor) {
            self::createDonationSheet($excel, Carbon::now()->subYear()->year, $donor);
            self::createDonationSheet($excel, Carbon::now()->year, $donor);
        })->export('xlsx');
    }

    private static function createDonationSheet($excel, $year, $donor) {
        $donations = $donor->donations()
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        if (count($donations) > 0) {
            $excel->sheet(__('donations.donations') . ' ' . $year, function($sheet) use($donations) {
                $sheet->setOrientation('landscape');
                $sheet->freezeFirstRow();
    
                // Data
                $sheet->loadView('donations.donations.export',[
                    'donations' => $donations,
                ]);
    
                // Currency formats
                for ($i = 0; $i < sizeof($donations); $i++) {
                    $sheet->getStyle('E' . ($i + 2))->getNumberFormat()->setFormatCode(Config::get('donations.currencies_excel_format')[$donations[$i]->currency]);
                }
                $sheet->getStyle('F')->getNumberFormat()->setFormatCode(Config::get('donations.base_currency_excel_format'));
    
                // Sum
                $sumCell = 'F' . (count($donations) + 2);
                $sheet->setCellValue($sumCell, '=SUM(F2:F' . (count($donations) + 1) . ')');
                $sheet->getStyle($sumCell)->getFont()->setUnderline(\PHPExcel_Style_Font::UNDERLINE_DOUBLEACCOUNTING);
            });
        }
    }

}