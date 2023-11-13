<?php

namespace App\Http\Controllers\Api;

use App\Models\CurrencyConversionPair;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

            $this->addCountidPaircurrency($from_currency, $to_currency);

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






    /**Récuperation du taux de conversion */
    public function extract_currency_rate($from_currency, $to_currency)
    {

        $exchange_rate = $this->currency_pair_converters->findByExchangeRate($from_currency, $to_currency)->exchange_rate;
        return $exchange_rate;
    }



    //IMise à jour du compteur d'utilisation de la pair
    public function addCountidPaircurrency($from_currency, $to_currency)
    {
        $id = $this->currency_pair_converters->findByExchangeRate($from_currency, $to_currency)->id;
        $find =   $this->currency_pair_converters->find($id);
        $find->count = $find->count + 1;
        $find->update();
        return $find;
    }




}
