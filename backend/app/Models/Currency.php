<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use App\Models\CurrencyConversionPair;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',

    ];


    public function findByCode($code)
    {
        $result = DB::table("currencies")->select(["*"])->where("code", "=", $code);
        return $result->get()->first();
    }

    /**
     * Obtenir le nombre d'occurence dans la tables pairs de devise en tant que from currency
     */
    public function fromCollections(): HasMany
    {
        return $this->hasMany(CurrencyConversionPair::class, "from_currency_id", );
    }
    /**
     * Obtenir le nombre d'occurence dans la tables pairs de devise en tant que to currenciy
     */
    public function toCollections(): HasMany
    {
        return $this->hasMany(CurrencyConversionPair::class, "to_currency_id", );
    }

}
