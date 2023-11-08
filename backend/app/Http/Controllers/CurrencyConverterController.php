<?php

namespace App\Http\Controllers;

use App\Models\CurrencyConversionPair;
use Illuminate\Http\Request;

class CurrencyConverterController extends Controller
{
    private $currency_pair_converters;


    public function __construct(CurrencyConversionPair $currency_pair_converters)
    {
        $this->currency_pair_converters = $currency_pair_converters;
    }

    /**
     * @param  string  $from_currency
     * @param  string  $to_currency
     * @param  int  $amount
     * @return \Illuminate\Http\Response
     */
    public function convert($from_currency, $to_currency, $amount)
    {



        try {

            $exchange_rate = $this->extract_currency_rate($from_currency, $to_currency);

            $converted = $amount * $exchange_rate;



            return response()->json([
                'message' => 'Conversion effectué',
                'from' => $from_currency,
                'to' => $to_currency,
                'result' => $converted,
                'pairCurrency' => $exchange_rate
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([

                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function extract_currency_rate($from_currency, $to_currency)
    {

        $exchange_rate = $this->currency_pair_converters->findByExchangeRate($from_currency, $to_currency)->exchange_rate;

        return $exchange_rate;

    }



}
