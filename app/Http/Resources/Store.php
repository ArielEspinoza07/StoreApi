<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Store extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'address'    => $this->address,
            'articles'   => $this->articles,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
