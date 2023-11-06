<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;
use App\Http\Resources\CurrencyRessource;
use Illuminate\Support\Facades\Validator;

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
            return CurrencyRessource::collection(Currency::get());
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
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 400);
            }


            $currency = Currency::create([
                'code' => $request->code,
                'name' => $request->name,
            ]);


            return response()->json([
                'message' => 'Devise crée',
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


            $currency->code =  $request->code;
            $currency->name =  $request->name;
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
