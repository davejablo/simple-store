<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
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
            'company_name' => $this->company_name,
            'country' => $this->country,
            'city' => $this->city,
            'state' => $this->postcode,
            'postcode' => $this->postcode,
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'logo' => $this->logo,
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}