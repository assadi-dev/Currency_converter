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
        return [
            "id" => $this->id,
            "codeFromCurrency" => $this->fromCurrency->code,
            "nameFromCurrency" => $this->fromCurrency->name,
            "codeToCurrency" =>  $this->toCurrency->code,
            "nameToCurrency" => $this->toCurrency->name,
            "exchange_rate" => $this->exchange_rate,
            "count" => $this->count
        ];
    }
}
