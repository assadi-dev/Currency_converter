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

        return [
            "id" => $this->id,
            "code" => $this->code,
            "name" => $this->name,
            "count" => $totalCount
        ];
    }
}
