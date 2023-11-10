<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
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

}
