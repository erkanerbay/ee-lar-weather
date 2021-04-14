<?php

namespace App\Weather;

use App\Exceptions\ApiException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

/**
 * Class WeatherClient
 * @package App\Weather
 * @doc https://weatherstack.com/documentation
 */
class WeatherClientWeatherstack implements WeatherClientInterface
{

    /**
     * @var string
     */
    private string $baseUrl = 'http://api.weatherstack.com';

    /**
     * @var array
     */
    private array $config;

    public function __construct()
    {
        $this->config = [
            'access_key' => config('weather.weatherstack.access_key'),
            'units' => 'm',
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
        $response = $response->json();

        if (isset($response['success']) && $response['success'] === false) {
            throw new ApiException($response['error']['info']);
        }

        return $response;
    }

    /**
     * @param  array  $params
     * @return array
     * @throws ApiException
     */
    public function current(array $params): array
    {
        $response = $this->request('/current', $params);

        $keys = [
            WeatherAttr::NAME => 'location.name',
            WeatherAttr::COUNTRY => 'location.country',
            WeatherAttr::DESCRIPTION => 'current.weather_descriptions',
            WeatherAttr::WIND_SPEED => 'current.wind_speed',
            WeatherAttr::WIND_DEGREE => 'current.wind_degree',
            WeatherAttr::TEMP => 'current.pressure',
            WeatherAttr::HUMIDITY => 'current.humidity',
            WeatherAttr::FEELS_LIKE => 'current.feelslike',
            WeatherAttr::PRESSURE => 'current.pressure'
        ];

        $data = [];
        foreach ($keys as $key => $getKey) {
            $data[$key] = Arr::get($response, $getKey, null);
        }

        if (isset($data[WeatherAttr::DESCRIPTION]) && is_array($data[WeatherAttr::DESCRIPTION])) {
            $data[WeatherAttr::DESCRIPTION] = implode(', ', $data[WeatherAttr::DESCRIPTION]);
        }

        return $data;
    }

    /**
     * @param  array  $params
     * @return array
     */
    public function forecast(array $params): array
    {
        $params = array_merge($params, ['forecast_days' => 3]);
        return $this->request('/forecast', $params);
    }

    /**
     * @param  array  $params
     * @return array
     */
    public function historical(array $params): array
    {
        $params = array_merge($params, ['historical_date' => '2021-04-09;2021-04-10']);
        return $this->request('/historical', $params);
    }
}
