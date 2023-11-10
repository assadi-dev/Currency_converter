<?php

namespace App\Http\Controllers\Api;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Resources\CurrencyRessource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            return CurrencyRessource::collection(Currency::paginate(5));
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
            $validateUser = Validator::make(
                $request->all(),
                [
                'code' => 'required',
                'name' => 'required',
                ]
            );

            if($validateUser->fails()) {
                return response()->json([
                    'message' => $validateUser->errors()
                ], 400);
            }
            $codeCurrency = trim(strtoupper($request->code));
            $nameCurrency = trim(ucwords($request->name));

            $currency = Currency::create([
                'code' => $codeCurrency,
                'name' => $nameCurrency,
            ]);


            return response()->json([
                'message' => 'Devise crée',
                'code' => $currency->code,
                'name' => $currency->name
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([

                'message' => $th->getMessage()
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
        try {
            $currency = Currency::find($id);

            if(!isset($currency)) {
                return response()->json([
                    'message' => 'Devise introuvable',
                ], 404);
            }

            return response()->json($currency);

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
            $validateUser = Validator::make(
                $request->all(),
                [
                'code' => 'required',
                'name' => 'required',
                ]
            );

            if($validateUser->fails()) {
                return response()->json([
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 400);
            }
            $currency = Currency::find($id);

            if(!isset($currency)) {
                return response()->json([
                    'message' => 'Devise introuvable',
                ], 404);
            }

            $codeCurrency = trim(strtoupper($request->code));
            $nameCurrency = trim(ucwords($request->name));


            $currency->code =  $codeCurrency;
            $currency->name =   $nameCurrency;
            $currency->update();




            return response()->json([
                'message' => 'la devise à été mise à jour',
                'code' => $currency->code,
                'name' => $currency->name
            ], 201);
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
        try {
            $currency = Currency::find($id);

            if(!isset($currency)) {
                return response()->json([
                    'message' => 'Devise introuvable',
                ], 404);
            }

            $currency->delete();
            return response()->json([
                'message' => 'Devise supprimé',

            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'server error',
                'errors' => $th->getMessage()
            ], 500);
        }
    }
}
