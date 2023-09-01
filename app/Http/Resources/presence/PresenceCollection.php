<?php

namespace App\Http\Resources\Presence;

use App\Http\Resources\Presence\PresenceResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PresenceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return PresenceResource::collection($this->collection);
    }
}