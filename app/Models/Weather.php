<?php

namespace App\Models;

use App\Weather\WeatherAttr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        WeatherAttr::NAME,
        WeatherAttr::COUNTRY,
        WeatherAttr::DESCRIPTION,
        WeatherAttr::WIND_SPEED,
        WeatherAttr::WIND_SPEED,
        WeatherAttr::WIND_DEGREE,
        WeatherAttr::HUMIDITY,
        WeatherAttr::TEMP,
        WeatherAttr::PRESSURE,
    ];
}
