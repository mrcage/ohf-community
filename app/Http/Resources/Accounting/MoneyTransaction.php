<?php

namespace App\Http\Resources\Accounting;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        $data['receipt_pictures'] = collect($this->receipt_pictures)
            ->filter(fn ($f) => Storage::exists($f))
            ->map(fn ($f) => [
                'url' => Storage::url($f),
                'thumbnail' => self::thumbnailUrl($f),
                'mime_type' => Storage::mimeType($f),
                'size' => bytes_to_human(Storage::size($f))
            ]);
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
        $data['can_book_externally'] = $request->user()->can('book-accounting-transactions-externally');
        $data['external_url'] = $this->externalUrl;
        $data['can_undo_booking'] = $request->user()->can('undoBooking', $this->resource);

        // TODO
        // $audit = $transaction->audits()->first();
        // if (isset($audit)) {
        //     $audit->getMetadata()['user_name']
        // }

        return $data;
    }

    private static function thumbnailUrl(string $file): ?string
    {
        if (Str::startsWith(Storage::mimeType($file), 'image/')) {
            if (Storage::exists(thumb_path($file))) {
                return Storage::url(thumb_path($file));
            }
            return Storage::url($file);
        }
        if (Storage::exists(thumb_path($file, 'jpeg'))) {
            return Storage::url(thumb_path($file, 'jpeg'));
        }
        return null;
    }
}
