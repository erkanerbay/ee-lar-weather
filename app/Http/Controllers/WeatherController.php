<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\WeatherRequest;
use App\Models\Weather;
use App\Weather\WeatherStates;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Weather\WeatherClient;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;


/**
 * Class WeatherController
 * @package App\Http\Controllers
 */
class WeatherController extends ApiController
{
    /**
     * @return mixed
     */
    public function latest()
    {
        return Weather::paginate();
    }

    /**
     * @return array
     */
    public function states():array
    {
        return Arr::flatten(array_values(WeatherStates::values()));
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function status(Request $request): JsonResponse
    {
        $rules = [
            'type'   => 'required|in:current,forecast,historical',
            'state'   => 'required|string',
            'start'  => 'required_if:type,historical|date_format:Y-m-d',
            'end'    => 'required_if:type,historical|nullable|date_format:Y-m-d'
        ];

        $validator = Validator::make($request->only(array_keys($rules)), $rules);

        if ($validator->fails()) {
            return self::validationError($validator);
        }

        $params = $validator->valid();
        $type = $params['type'];
        //$cacheKey = $type.$params['state'];

        unset($params['type']);

        // check prams has a cache
        //if (Cache::has($cacheKey)) {
        //    return response()->json(Cache::get($cacheKey));
        //}

        $weatherClient = new WeatherClient(WeatherClient::OPENWEATHERMAP);
        $response = $weatherClient->{$type}($params);

        // Cache response
        // Cache::put($cacheKey, $response, now()->addMinutes(60));

        return response()->json($response);
    }
}
