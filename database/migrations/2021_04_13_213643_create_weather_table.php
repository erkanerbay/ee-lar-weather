<?php

use App\Weather\WeatherAttr;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather', function (Blueprint $table) {
            $table->id();

            $table->string(WeatherAttr::NAME)->nullable();
            $table->string(WeatherAttr::COUNTRY)->nullable();
            $table->string(WeatherAttr::DESCRIPTION)->nullable();
            $table->double(WeatherAttr::WIND_SPEED)->nullable();
            $table->double(WeatherAttr::WIND_SPEED)->nullable();
            $table->double(WeatherAttr::WIND_DEGREE)->nullable();
            $table->double(WeatherAttr::HUMIDITY)->nullable();
            $table->double(WeatherAttr::TEMP)->nullable();
            $table->double(WeatherAttr::PRESSURE)->nullable();

            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather');
    }
}
