<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StoreCollection extends ResourceCollection
{

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $resource = [
            'stores'         => $this->collection,
            'total_elements' => $this->collection->count(),
        ];
        if (method_exists($this->resource, 'total')) {
            $resource['pagination'] = [
                'total'         => $this->total(),
                'count'         => $this->count(),
                'per_page'      => $this->perPage(),
                'previous_page' => ($this->currentPage() - 1),
                'current_page'  => $this->currentPage(),
                'next_page'     => ($this->currentPage() + 1),
                'first_page'    => 1,
                'last_page'     => $this->lastPage(),
                'total_pages'   => $this->lastPage(),
            ];
        }

        return $resource;
    }
}
