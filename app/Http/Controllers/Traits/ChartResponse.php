<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Collection;

trait ChartResponse
{
    private function singleSetChartResponse(string $title, Collection $data, ?string $unit = null)
    {
        return response()->json([
            'labels' => $data->keys()->map(fn ($v) => strval($v)),
            'datasets' => [
                [
                    'label' => $title,
                    'data' => $data->values(),
                    'unit' => $unit !== null ? $unit : __('app.quantity'),
                ]
            ]
        ]);
    }
}
