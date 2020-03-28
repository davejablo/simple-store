<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'barcode' => $this->barcode,
            'unit_price' => $this->unit_price,
            'in_stock' => $this->in_stock,
            'picture' => $this->picture,
            'supplier' => new SupplierResource($this->whenLoaded('supplier')),
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}
