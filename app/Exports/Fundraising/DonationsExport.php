<?php

namespace App\Exports\Fundraising;

use App\Exports\DefaultFormatting;

use App\Models\Fundraising\Donor;
use App\Models\Fundraising\Donation;
use App\Exports\Fundraising\Sheets\DonationsSheet;
use App\Exports\Fundraising\Sheets\DonationsWithDonorSheet;

use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;

class DonationsExport implements WithMultipleSheets, WithEvents
{
    use Exportable, DefaultFormatting;

    private $donor;

    public function __construct(?Donor $donor = null)
    {
        $this->donor = $donor;
    }

    private function getDonationsQuery(?int $year = null)
    {
        $qry = $this->donor != null ? $this->donor->donations() : Donation::query();
        if ($year != null) {
            $qry->whereYear('date', $year);
        }
        return $qry;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $years = Donation::select(DB::raw('YEAR(date) as year'))
            ->groupBy('year')
            ->orderBy('year')
            ->get()
            ->pluck('year');
        foreach ($years as $year) {
            if ($this->getDonationsQuery($year)->count() > 0) {
                $data = $this->getDonationsQuery($year)
                    ->orderBy('date', 'asc')
                    ->orderBy('created_at', 'asc')
                    ->get();
                $sheets[] = $this->donor != null ? new DonationsSheet($data, $year) : new DonationsWithDonorSheet($data, $year);
            }
        }

        return $sheets;
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function(BeforeExport $event) {
                $spreadsheet = $event->writer->getDelegate();
                $this->setupSpreadsheet($spreadsheet);
            },
            BeforeWriting::class => function(BeforeWriting $event) {
                $spreadsheet = $event->writer->getDelegate();
                $spreadsheet->setActiveSheetIndex($spreadsheet->getSheetCount() - 1);
            },
        ];
    }
}