<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EventCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($event) {
            return [
                'id' => $event->id,
                'user' => new UserResource($event->user),
                'title' => $event->title,
                'description' => $event->description,
                'start_at' => $event->start_at->format('Y-m-d H:i:s'),
                'end_at' => $event->end_at->format('Y-m-d H:i:s'),
                'status' => $event->present()->status
            ];
        });
    }
}
