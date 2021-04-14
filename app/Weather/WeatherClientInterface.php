<?php

namespace App\Weather;

/**
 * Interface WeatherClientInterface
 * @package App\Weather
 */
interface WeatherClientInterface
{
    public function current(array $params): array;

    public function forecast(array $params): array;

    public function historical(array $params): array;
}
