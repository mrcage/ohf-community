<?php

namespace App\Http\Resources\Accounting;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class MoneyTransaction extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['receipt_pictures'] = collect($this->receipt_pictures)->map(fn ($f) => Storage::url($f));
        $data['supplier'] = $this->whenLoaded('supplier', function () {
            return collect($this->supplier)->only(['slug', 'name']);
        });
        $data['can_update'] = $request->user()->can('update', $this->resource);
        $data['can_delete'] = $request->user()->can('delete', $this->resource);
        return $data;
    }
}
