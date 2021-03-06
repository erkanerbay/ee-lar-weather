<?php

namespace App\Weather;

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
     * @return string[]
     */
    private function getKeys(): array
    {
        $keys = [
            self::WEATHERSTACK => [
                'query' => 'state'
            ],
            self::OPENWEATHERMAP => [
                'q' => 'state'
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
        return $this->client->forecast($this->standardize($params));
    }

    /**
     * @param  array  $params
     * @return array
     */
    final public function historical(array $params): array
    {
        return $this->client->historical($this->standardize($params));
    }
}
