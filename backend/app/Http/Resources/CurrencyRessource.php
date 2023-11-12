<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyRessource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $totalCount = $this->fromCollections->count() + $this->toCollections->count();

        $toCurrencyList = [];
        //Recuperation des devise disponnibles
        foreach ($this->toCollections as $currency) {
            $totalCountCurrency = $currency->fromCurrency->fromCollections->count() + $currency->fromCurrency->toCollections->count();
            $value["id"] = $currency->id;
            $value["code"] = $currency->fromCurrency->code;
            $value["name"] = $currency->fromCurrency->name;
            $value["count"] = $totalCountCurrency;
            array_push($toCurrencyList, $value);
        }


        return [
            "id" => $this->id,
            "code" => $this->code,
            "name" => $this->name,
            "count" => $totalCount,
            "toCurrencyAvailable" =>  $toCurrencyList

        ];
    }
}
