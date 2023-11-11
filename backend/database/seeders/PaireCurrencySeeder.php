<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\CurrencyConversionPair;
use Illuminate\Database\Seeder;

class PaireCurrencySeeder extends Seeder
{
    private $currencies;

    public function __construct(Currency $currencies)
    {
        $this->currencies = $currencies;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $PaireCurrencyCollections = [
        [
            "codeFromCurrency" => "GBP",
            "nameFromCurrency" => "Livre sterling Britannique",
            "codeToCurrency" => "EUR",
            "nameToCurrency" => "Euro",
            "exchange_rate" => 1.01423401
        ],
        [
            "codeFromCurrency" => "GBP",
            "nameFromCurrency" => "Livre sterling Britannique",
            "codeToCurrency" => "USD",
            "nameToCurrency" => "Dollar de Etats-Unis",
            "exchange_rate" => 1.2223348
        ],
        [
            "codeFromCurrency" => "EUR",
            "nameFromCurrency" => "Euro",
            "codeToCurrency" => "USD",
            "nameToCurrency" => "Dollar de Etats-Unis",
            "exchange_rate" =>  1.0698679,
        ],
        [
            "codeFromCurrency" => "CHF",
            "nameFromCurrency" => "Franc suisse",
            "codeToCurrency" => "Euro",
            "nameToCurrency" => "Euro",
            "exchange_rate" => 1.1078207
        ],
    ];


        foreach ($PaireCurrencyCollections as $pairCurrency) {

            $codeFromCurrency  =  $pairCurrency["codeFromCurrency"];
            $nameFromCurrency  =  $pairCurrency["nameFromCurrency"];
            $codeToCurrency  =  $pairCurrency["codeToCurrency"];
            $nameToCurrency  =  $pairCurrency["nameToCurrency"];
            $exchange_rate = $pairCurrency["exchange_rate"];


            $findFromCurrency = $this->currencies->findByCode($codeFromCurrency);
            $findToCurrency = $this->currencies->findByCode($codeToCurrency);
            $from_currency_id = null;
            $to_currency_id = null;

            if(!empty($findFromCurrency)) {
                $from_currency_id =  $findFromCurrency->id ;
            } else {
                $newFromCurrency = Currency::create([
                    'code' => $codeFromCurrency,
                    'name' => $nameFromCurrency,
                ]);
                $from_currency_id = $newFromCurrency->id ;
            }
            if(!empty($findToCurrency)) {
                $to_currency_id =  $findToCurrency->id ;
            } else {
                $newToCurrency = Currency::create([
                    'code' => $codeToCurrency,
                    'name' => $nameToCurrency,
                ]);
                $to_currency_id =  $newToCurrency->id ;
            }




            //Creation des paires
            CurrencyConversionPair::create([
                'from_currency_id' => $from_currency_id,
                'to_currency_id' => $to_currency_id,
                'exchange_rate' => $exchange_rate,
                'count' => 0
            ]);
            //Creation des paires inverses
            $exchange_rate_inversed = 1 / floatval($exchange_rate);
            CurrencyConversionPair::create([
                'from_currency_id' => $to_currency_id,
                'to_currency_id' => $from_currency_id ,
                'exchange_rate' =>  $exchange_rate_inversed,
                'count' => 0
            ]);


        }




    }
}
