<?php

namespace App\Weather;

use App\Exceptions\ApiException;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

/**
 * Class WeatherClient
 * @package App\Weather
 * @doc https://openweathermap.org/current
 */
class WeatherClientOpenweathermap implements WeatherClientInterface
{
    /**
     * @var string
     */
    private string $baseUrl = 'http://api.openweathermap.org/data/2.5';

    /**
     * @var array
     */
    private array $config;

    public function __construct()
    {
        $this->config = [
            'appid' => config('weather.openweathermap.appid'),
            'units' => 'metric',
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
        $response = Http::get($this->baseUrl.$url, $params);
        $body = $response->json();

        if ($response->failed()) {
            throw new ApiException($body['message']);
        }

        return $body;
    }

    /**
     * @param  array  $apiData
     * @return array
     */
    private function standardize(array $apiData): array
    {
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
            WeatherAttr::DATETIME => 'dt',
        ];

        $data = [];

        foreach ($keys as $key => $getKey) {
            $data[$key] = Arr::get($apiData, $getKey, null);
        }

        $dt = Arr::get($data, WeatherAttr::DATETIME, null);

        if ($dt) {
            $data[WeatherAttr::DATETIME] = Carbon::createFromTimestampUTC($dt)->toDateTimeString();
        }

        return $data;
    }

    /**
     * @param  array  $params
     * @return array
     * @throws ApiException
     */
    public function current(array $params): array
    {
        $response = $this->request('/weather', $params);
        return $this->standardize($response);
    }

    /**
     * @param  array  $params
     * @return array
     */
    public function forecast(array $params): array
    {
        $params = array_merge($params, ['cnt' => 16]);
        $response = $this->request('/forecast', $params);

        if (!isset($response['list']) || !is_array($response['list'])) {
            return [];
        }

        return array_map(function ($apiData) {
            return $this->standardize($apiData);
        }, $response['list']);
    }

    /**
     * @param  array  $params
     * @return array
     * @see https://openweathermap.org/forecast16
     */
    public function historical(array $params): array
    {
        $params = array_merge($params, ['type' => 'hour']);
        return $this->request('/history/city', $params);
    }
}
