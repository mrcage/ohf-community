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
        $data['supplier'] = $this->whenLoaded('supplier', fn () =>
            collect($this->supplier)->only(['slug', 'name', 'category'])
        );
        $data['can_view_supplier'] = $this->whenLoaded('supplier', fn () =>
            $request->user()->can('view', $this->supplier)
        );
        $data['controller'] = $this->whenLoaded('controller', fn () =>
            collect($this->controller)->only(['id', 'name'])
        );
        $data['can_undo_controlling'] = $this->whenLoaded('controller', fn () =>
            $request->user()->can('undoControlling', $this->resource)
        );
        $data['can_update'] = $request->user()->can('update', $this->resource);
        $data['can_delete'] = $request->user()->can('delete', $this->resource);
        return $data;
    }
}
