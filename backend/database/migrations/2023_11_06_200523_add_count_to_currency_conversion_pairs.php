<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountToCurrencyConversionPairs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('currency_conversion_pairs', function (Blueprint $table) {
            //
            $table->integer('count')->after('exchange_rate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('currency_conversion_pairs', function (Blueprint $table) {
            //
            $table->dropColumn('count');
        });
    }
}
