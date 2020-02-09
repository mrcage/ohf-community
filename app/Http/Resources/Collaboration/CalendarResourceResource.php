<?php

namespace App\Http\Resources\Collaboration;

use Illuminate\Http\Resources\Json\Resource;

class CalendarResourceResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'group' => $this->group,
            'eventColor' => $this->color,
            'default' => $this->default,
            'url' => route('calendar.resources.show', $this),
        ];
    }
}