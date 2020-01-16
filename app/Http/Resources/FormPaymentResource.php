<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormPaymentResource extends JsonResource
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
            'amount'        => $this->amount ?: 0,
            'description'   => $this->description ?: null,
            'coupon'        => unserialize($this->coupon) ?: [],
        ];
    }
}
