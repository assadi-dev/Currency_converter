<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CurrencyConversionPair;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CurrencyConversionPairsRessource;

class CurrencyConversionPairsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return CurrencyConversionPairsRessource::collection(CurrencyConversionPair::all());
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'server error',
                'errors' => $th->getMessage()
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
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
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
                'message' => 'server error',
                'errors' => $th->getMessage()
            ], 500);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
