<?php

namespace App\Http\Resources;

use App\Util\TransformUtil;
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
            'created_at' => TransformUtil::giveFormatDate($this->created_at,env('DATE_FORMAT_US')),
            'updated_at' => TransformUtil::giveFormatDate($this->updated_at,env('DATE_FORMAT_US')),
        ];
    }
}
