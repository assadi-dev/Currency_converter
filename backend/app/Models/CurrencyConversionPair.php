<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CurrencyConversionPair extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_currency_id',
        'to_currency_id',
        'exchange_rate',
        'count',
    ];

    public function fromCurrency()
    {
        return $this->belongsTo(Currency::class, 'from_currency_id');
    }

    public function toCurrency()
    {
        return $this->belongsTo(Currency::class, 'to_currency_id');
    }


    /**
     *  @param string from_currency
     *  @param string to_currency
     *
     *
     */
    public static function findByExchangeRate($from_currency, $to_currency)
    {
        $results = DB::table("currency_conversion_pairs")
        ->selectRaw("currency_conversion_pairs.id,currencies.code as from_currency, toCurrency.code as to_currency ,exchange_rate")
        ->leftJoin('currencies', "currencies.id", '=', "currency_conversion_pairs.from_currency_id")
         ->leftJoin('currencies as toCurrency', "toCurrency.id", '=', "currency_conversion_pairs.to_currency_id")
         ->whereRaw('currencies.code = ?', $from_currency)
         ->whereRaw('toCurrency.code = ?', $to_currency)
        ->get()
        ;

        if(isset($results)) {

            return  $results[0];
        } else {
            return null;
        }
    }


}
