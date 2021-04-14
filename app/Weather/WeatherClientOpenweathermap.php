<?php

namespace App\Weather;

use App\Exceptions\ApiException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

/**
 * Class WeatherClient
 * @package App\Weather
 * @doc https://openweathermap.org/current
 */
class WeatherClientOpenweathermap implements WeatherClientInterface
{
    /**
     * @var array
     */
    private array $config;

    public function __construct()
    {
        $this->config = [
            'appid' => config('weather.openweathermap.appid'),
            'units' => 'metric'
        ];
    }

    /**
     * @param  string  $url
     * @param  array  $params
     * @return array
     * @throws ApiException
     */
    private function request(string $url, array $params): array
    {
        $params = array_merge($params, $this->config);
        $response = Http::get($url, $params);
        $body = $response->json();

        if ($response->failed()) {
            throw new ApiException($body['message']);
        }

        return $body;
    }

    /**
     * @param  array  $params
     * @return array
     * @throws ApiException
     */
    public function current(array $params): array
    {
        $url = 'https://api.openweathermap.org/data/2.5/weather';
        $response = $this->request($url, $params);

        $keys = [
            WeatherAttr::NAME => 'name',
            WeatherAttr::COUNTRY => 'sys.country',
            WeatherAttr::DESCRIPTION => 'weather.0.description',
            WeatherAttr::WIND_SPEED => 'wind.speed',
            WeatherAttr::WIND_DEGREE => 'wind.deg',
            WeatherAttr::HUMIDITY => 'main.humidity',
            WeatherAttr::FEELS_LIKE => 'main.feels_like',
            WeatherAttr::TEMP => 'main.temp',
            WeatherAttr::PRESSURE => 'main.pressure',
        ];

        $data = [];
        foreach ($keys as $key => $getKey) {
            $data[$key] = Arr::get($response, $getKey, null);
        }

        return $data;
    }

    /**
     * @param  array  $params
     * @return array
     */
    public function forecast(array $params): array
    {
        $params = array_merge($params, ['cnt' => 4]);
        $url = 'api.openweathermap.org/data/2.5/forecast/daily';
        return $this->request($url, $params);
    }

    /**
     * @param  array  $params
     * @return array
     * @see https://openweathermap.org/forecast16
     */
    public function historical(array $params): array
    {
        $params = array_merge($params, ['type' => 'hour']);
        $url = 'http://api.openweathermap.org/data/2.5/history/city';
        return $this->request($url, $params);
    }
}
