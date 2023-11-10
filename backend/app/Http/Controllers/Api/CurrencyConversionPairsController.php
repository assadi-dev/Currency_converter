<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\CurrencyConversionPair;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CurrencyConversionPairsRessource;
use App\Http\Controllers\Controller;
use App\Models\Currency;

class CurrencyConversionPairsController extends Controller
{
    private $currencies;

    public function __construct(Currency $currencies)
    {
        $this->currencies = $currencies;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return CurrencyConversionPairsRessource::collection(CurrencyConversionPair::paginate(5));
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //Validation
            $validateUser = Validator::make(
                $request->all(),
                [
                'from_currency_id' => 'required',
                'to_currency_id' => 'required',
                'exchange_rate' => 'required'
                ]
            );

            if($validateUser->fails()) {
                return response()->json([
                    'message' => $validateUser->errors()
                ], 400);
            }



            $from_currency_id = $request->from_currency_id;
            $to_currency_id = $request->to_currency_id;
            $exchange_rate = $request->exchange_rate;




            $CurrencyConversionPair  = CurrencyConversionPair::create([
                'from_currency_id' => $from_currency_id,
                'to_currency_id' => $to_currency_id,
                'exchange_rate' => $exchange_rate,
            ]);




            return response()->json([
                'message' => 'Paire de conversion crée',
                "id" => $CurrencyConversionPair->id,
                'from_currency' => $CurrencyConversionPair->fromCurrency,
                'to_currency' => $CurrencyConversionPair->toCurrency,
                'exchange_rate' => $CurrencyConversionPair->exchange_rate
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage by code currency.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeByCode(Request $request)
    {
        try {
            //Validation
            $validateUser = Validator::make(
                $request->all(),
                [
                        'codeFromCurrency' => 'required|unique:Currency',
                        'nameFromCurrency' => 'required|unique:Currency',
                        'codeToCurrency' => 'required',
                        'nameToCurrency' => 'required',
                        'exchange_rate' => 'required'
                    ]
            );

            $codeFromCurrency = $request->codeFromCurrency;
            $nameFromCurrency = $request->nameFromCurrency;
            $codeToCurrency = $request->codeToCurrency;
            $nameToCurrency = $request->nameToCurrency;
            $exchange_rate = $request->exchange_rate;

            //initialisation de la paire
            $newPaireCurrency = new CurrencyConversionPair();

            //Vérification de l'existence de la devise dans la Base de donnée
            $findFromCurrency = $this->currencies->findByCode($codeFromCurrency);
            $findToCurrency = $this->currencies->findByCode($codeToCurrency);
            $from_currency_id = null;
            $to_currency_id = null;

            if(!empty($findFromCurrency)) {
                $from_currency_id =  $findFromCurrency->id ;
            } else {
                $findFromCurrency = Currency::create([
                   'code' => $codeFromCurrency,
                   'name' => $nameFromCurrency,
                    ]);
                $from_currency_id =  $findFromCurrency->id ;
            }
            if(!empty($findToCurrency)) {
                $to_currency_id = $findToCurrency->id;

            } else {
                $findToCurrency = Currency::create([
                   'code' => $codeToCurrency,
                   'name' => $nameToCurrency,
                     ]);
                $to_currency_id = $findToCurrency->id;

            }


            $newPaireCurrency = new CurrencyConversionPair();


            $newPaireCurrency->from_currency_id = $from_currency_id;
            $newPaireCurrency->to_currency_id = $to_currency_id;
            $newPaireCurrency->exchange_rate = $exchange_rate ;
            $newPaireCurrency->count = 0;
            $newPaireCurrency->save();



            $pairCurrency = [
               "codeFromCurrency" => $newPaireCurrency->fromCurrency->code,
                "nameFromCurrency" =>  $newPaireCurrency->fromCurrency->name,
                "codeToCurrency" =>  $newPaireCurrency->toCurrency->code,
                "nameToCurrency" =>  $newPaireCurrency->toCurrency->name,
                "exchange_rate" =>  $newPaireCurrency->exchange_rate,
                "count" => $newPaireCurrency->count
            ];

            return response()->json([ 'message' => 'Paire de conversion crée',"data" => $pairCurrency], 201);

        } catch (\Throwable $th) {
            //throw $th;
            $message = $th->getMessage();
            return response()->json(["message" => $message], 500);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $currencyConversionPair = CurrencyConversionPair::find($id);
            if(!isset($currencyConversionPair)) {
                return response()->json([
                    'message' => 'no found',
                    'errors' =>  'Paire introuvable'
                ], 404);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'server error',
                'errors' => $th->getMessage()
            ], 500);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $currencyConversionPair = CurrencyConversionPair::find($id);
            if(!isset($currencyConversionPair)) {
                return response()->json([
                    'message' => 'no found',
                    'errors' =>  'Paire introuvable'
                ], 404);
            }


            $currencyConversionPair->exchange_rate = $request->exchange_rate;
            $currencyConversionPair->update();

            return response()->json([
                'message' => 'Paire de conversion modifié',
                "id" => $currencyConversionPair->id,
                'from_currency' => $currencyConversionPair->fromCurrency,
                'to_currency' => $currencyConversionPair->toCurrency,
                'exchange_rate' => $currencyConversionPair->exchange_rate
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'server error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currencyConversionPair = CurrencyConversionPair::find($id);
        if(!isset($currencyConversionPair)) {
            return response()->json([
                'message' => 'no found',
                'errors' =>  'Paire introuvable'
            ], 404);
        }

        $currencyConversionPair->delete();
        return response()->json([
            "message" => "paire supprimé",
        ], 200);
    }
}
