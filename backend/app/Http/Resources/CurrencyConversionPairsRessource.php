<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyConversionPairsRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray([
            "id" => $this->id,
            "from_currency" => ["code" => $this->fromCurrency->code,"name" => $this->fromCurrency->code],
            "to_currency" => ["code" => $this->toCurrency->code,"name" => $this->toCurrency->code],
            "exchange_rate" => $this->exchange_rate,
            "count" => $this->count
        ]);
    }
}