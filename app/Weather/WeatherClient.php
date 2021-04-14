<?php

namespace App\Weather;

use Illuminate\Support\Str;

/**
 * Class WeatherClient
 * @package App\Weather
 */
class WeatherClient implements WeatherClientInterface
{
    public const WEATHERSTACK = 'Weatherstack';
    public const OPENWEATHERMAP = 'Openweathermap';

    /**
     * @var string
     */
    private string $name;

    /**
     * @var string
     */
    private $client;

    /**
     * WeatherClient constructor.
     * @param  string  $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $client = "\\App\\Weather\\WeatherClient".$name;
        $this->client = new $client();
    }

    /**
     * @return array
     */
    public function names():array{
        return array_map(static function ($name) {
            return Str::lower($name);
        }, [self::OPENWEATHERMAP, self::WEATHERSTACK]);
    }

    /**
     * @return string[]
     */
    private function getKeys(): array
    {
        $keys = [
            self::WEATHERSTACK => [
                'query' => 'city'
            ],
            self::OPENWEATHERMAP => [
                'q' => 'city'
            ]
        ];

        return $keys[$this->name];
    }

    /**
     * @param  array  $params
     * @return array
     */
    private function standardize(array $params): array
    {
        foreach ($this->getKeys() as $apiKey => $selfApiKey) {
            if (isset($params[$selfApiKey])) {
                $params[$apiKey] = $params[$selfApiKey];
                unset($params[$selfApiKey]);
            }
        }

        return $params;
    }

    /**
     * @param  array  $params
     */
    final public function current(array $params): array
    {
        return $this->client->current($this->standardize($params));
    }

    /**
     * @param  array  $params
     * @return array
     */
    final public function forecast(array $params): array
    {
        $params = $this->standardize($params);
        return $this->client->forecast($params);
    }

    /**
     * @param  array  $params
     * @return array
     */
    final public function historical(array $params): array
    {
        $params = $this->standardize($params);
        return $this->client->historical($params);
    }
}
