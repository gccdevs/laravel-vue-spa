<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'ref'         => $this->transaction_ref,
            'purpose'     => $this->transaction_purpose,
            'description' => $this->transaction_description,
            'platform'    => $this->transaction_platform,
            'status'      => $this->transaction_status,
            'amount'      => 'A$' . monie_format($this->transaction_amount),
            'email'       => $this->transaction_email,
            'refunded'    => $this->transaction_refunded,
        ];
    }

}
